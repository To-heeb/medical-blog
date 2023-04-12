<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'title' =>  $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraph(5),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'published' => true,
            'published_at' => now()->format('Y-m-d H:i:S')
        ];
    }
}
