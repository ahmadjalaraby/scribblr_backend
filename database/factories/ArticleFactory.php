<?php

namespace Database\Factories;

use App\Constants\DateTime\DateTimeFormat;
use App\Enums\Article\ArticleStatus;
use App\Models\Article;
use App\Services\HtmlGeneratorService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $htmlGeneratorService = new HtmlGeneratorService(
            numElements: 30,
        );
//        dd($htmlGeneratorService->generateRandomHtmlContent());

        return [
            'title' => fake()->text(100),
            'content' => $htmlGeneratorService->generateRandomHtmlContent(),
            'status' => fake()->randomElement(ArticleStatus::class),
            'allow_comments' => fake()->boolean(),
            'publish_time' => fake()->dateTimeBetween(startDate: 'now', endDate: '30 days'),
            'tag_id' => fake()->numberBetween(int1: 1, int2: 20),
            'user_id' => fake()->numberBetween(int1: 1, int2: 3000),
            'created_at' => fake()->dateTimeBetween(startDate: '-1 year')
                ->format(DateTimeFormat::DEFAULT),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }
}
