<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            PostSeeder::class,
            QuestionSeeder::class,
            CommentSeeder::class,
            NewsletterSubscriptionSeeder::class,
            LikeSeeder::class
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Toheeb Oyekola',
            'first_name' => 'Toheeb',
            'last_name' => 'Oyekola',
            'email' => 'toheeb@admin.com',
            'password' => Hash::make('admin'),
        ])->assignRole('super-admin');


        \App\Models\User::factory()->create([
            'name' => 'Haarith Oyekola',
            'first_name' => 'Haarith',
            'last_name' => 'Oyekola',
            'email' => 'haarith@gmail',
            'password' => Hash::make('password'),
        ])->assignRole('user');
    }
}
