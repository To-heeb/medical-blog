<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'name' => 'Toheeb Oyekola',
            'first_name' => 'Toheeb',
            'last_name' => 'Oyekola',
            'email' => 'toheeb@admin.com',
            'password' => Hash::make('admin'),
        ]);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\RoleSeeder::class);

        $user->assignRole('super-admin');

        $this->withoutExceptionHandling();
    }


    /**
     * @test
     */
    public function it_gets_users_list()
    {
        $users = User::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.users.index'));

        $response->assertOk()->assertSee($users[0]->name);
    }


    /**
     * @test
     */
    public function it_stores_the_user()
    {
        $user = User::factory()
            ->make()->toArray();

        $user["role"] = "user";
        $user["name"] = Str::slug($user["first_name"]);
        $user['password'] = 'password';
        $user['password_confirmation'] = 'password';
        $response = $this->postJson(route('api.users.store'), $user);

        unset($user['password']);
        unset($user['password_confirmation']);
        unset($user['role']);
        unset($user['email_verified_at']);
        unset($user['avatar']);

        $this->assertDatabaseHas('users', $user);

        $response->assertStatus(201)->assertJsonFragment($user);
    }


    /**
     * @test
     */
    public function it_updates_the_user()
    {
        $user = User::factory()->create();

        $data = [
            'last_name' => $this->faker->name,
            'first_name' => $this->faker->name,
            'email' => $this->faker->unique->email
        ];

        $data["name"] = Str::slug($data["first_name"]);

        $response = $this->putJson(route('api.users.update', $user), $data);

        unset($user['password']);
        unset($user['role']);
        unset($user['email_verified_at']);
        unset($user['avatar']);;

        $data['id'] = $user->id;

        $this->assertDatabaseHas('users', $data);

        $response->assertOk()->assertJsonFragment($data);
    }


    /**
     * @test
     */
    public function it_deletes_the_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson(route('api.users.destroy', $user));

        $this->assertModelMissing($user);

        $response->assertNoContent();
    }
}
