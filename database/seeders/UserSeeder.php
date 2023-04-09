<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->hasPosts(3)
            ->hasQuestions(3)
            ->hasComments(3)
            ->hasLikes(3)
            ->create()
            ->assignRole('user');
    }
}
