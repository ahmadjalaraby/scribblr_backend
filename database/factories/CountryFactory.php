<?php

namespace Database\Factories;

use App\Constants\DateTime\DateTimeFormat;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->country(),
            'code' => fake()->countryCode(),
            'start' => fake()->numberBetween(100, 999),
            'created_at' => date(DateTimeFormat::DEFAULT),
            'updated_at' => date(DateTimeFormat::DEFAULT),
        ];
    }
}
