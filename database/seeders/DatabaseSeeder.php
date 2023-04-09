<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
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
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ])->assignRole('super-admin');
    }
}
