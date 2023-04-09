<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Like::factory()->count(3)->for(
            Post::factory(),
            'likeable'
        )->create();

        Like::factory()->count(3)->for(
            Question::factory(),
            'likeable'
        )->create();
    }
}
