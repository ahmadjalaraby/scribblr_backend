<?php

namespace Database\Factories;

use App\Constants\DateTime\DateTimeFormat;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Like>
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
        return [
            'user_id' => fake()->numberBetween(int1: 1, int2: 3_000),
            'comment_id' => fake()->numberBetween(int1: 1, int2: 20_000),
            'created_at' =>  fake()->dateTimeBetween(startDate: '-1 year', endDate: 'now')
                ->format(DateTimeFormat::DEFAULT),
            'updated_at' => now(),
        ];
    }
}
