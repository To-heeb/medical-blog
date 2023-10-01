<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use App\Models\User;
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
}
