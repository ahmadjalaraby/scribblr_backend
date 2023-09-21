<?php

namespace Database\Factories;

use App\Constants\DateTime\DateTimeFormat;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
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
            'article_id' => fake()->numberBetween(int1: 1, int2: 50_000),
            'created_at' => fake()->dateTimeBetween(startDate: '-30 days', endDate: 'now')
                ->format(DateTimeFormat::DEFAULT),
            'updated_at' => now(),
        ];
    }
}
