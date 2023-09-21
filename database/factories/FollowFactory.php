<?php

namespace Database\Factories;

use App\Constants\DateTime\DateTimeFormat;
use App\Models\Follow;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'follower_id' => fake()->numberBetween(int1: 1, int2: 3_000),
            'followed_id' => fake()->numberBetween(int1: 1, int2: 3_000),
            'created_at' => fake()->dateTimeBetween(startDate: '-1 year', endDate: 'now')
                ->format(DateTimeFormat::DEFAULT),
            'updated_at' => now(),
        ];
    }
}
