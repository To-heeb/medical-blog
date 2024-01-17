<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use App\Models\Post;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'name' => 'Toheeb Oyekola',
            'first_name' => 'Toheeb',
            'last_name' => 'Oyekola',
            'email' => 'toheeb@user.com',
            'password' => Hash::make('admin'),
        ]);
        // $user->dump();
        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\RoleSeeder::class);

        $user->assignRole('user');

        $this->user =  $user;

        $this->withoutExceptionHandling();
    }


    /**
     * @test
     */
    public function it_gets_posts_list()
    {
        $posts = Post::factory()
            ->hasComments(5)
            ->hasTags(3)
            ->count(2)
            ->create();

        $response = $this->getJson(route('api.posts.index'));

        $response->assertOk()->assertSee($posts[0]->title);
    }


    /**
     * @test
     */
    public function it_stores_the_post()
    {
        $posts = Post::factory()
            ->make()->toArray();

        $post["user_id"] = $this->user->id;

        $response = $this->postJson(route('api.posts.store'), $posts);

        $posts['published'] = 0;
        $posts['published_at'] = null;
        $response->dump();

        $this->assertDatabaseHas('posts', $posts);

        $post["user_id"] = $this->user->id;

        $response->assertStatus(201)->assertJsonFragment($posts);
    }


    /**
     * @test
     */
    public function it_updates_the_post()
    {
        $category = Category::factory()->create();
        $post = Post::factory()
            ->hasComments(5)
            ->hasTags(3)
            ->create();


        $data = [
            'title' => $post->title,
            'content' => $post->content,
            'category_id' => $category->id
        ];

        $response = $this->putJson(route('api.posts.update', $post), $data);

        $data['id'] = $post->id;

        $this->assertDatabaseHas('posts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }


    /**
     * @test
     */
    public function it_deletes_the_post()
    {
        $post = Post::factory()->create();

        $post->user_id = $this->user->id;

        $response = $this->deleteJson(route('api.posts.destroy', $post));

        $this->assertModelMissing($post);

        $response->assertNoContent();
    }
}
