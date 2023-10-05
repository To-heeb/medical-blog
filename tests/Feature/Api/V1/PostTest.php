<?php

namespace Tests\Feature\Api\V1;

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

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\RoleSeeder::class);

        $user->assignRole('user');

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
}
