<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $likeable_type = $this->likeable_type();

        return [
            'likeable_type' => $likeable_type['likeable_type'],
            'likeable_id' => $likeable_type['likeable_id'],
            'user_id' => User::factory()
        ];
    }

    private function likeable_type(): array
    {
        $index = rand(0, 1);
        $type = [
            [
                'likeable_type' => 'App\Models\Post',
                'likeable_id' => Post::factory(),
            ],
            [
                'likeable_type' => 'App\Models\Question',
                'likeable_id' => Question::factory(),
            ]
        ];

        return $type[$index];
    }
}
