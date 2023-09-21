<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $records = Article::factory()->count(10_000)->make();

            $records->chunk(500)->each(function ($chunk) {
                Article::insert($chunk->toArray());
            });
        }
    }
}
