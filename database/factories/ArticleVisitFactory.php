<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Constants\DateTime\DateTimeFormat;
use App\Models\ArticleVisit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ArticleVisit>
 */
class ArticleVisitFactory extends Factory
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
