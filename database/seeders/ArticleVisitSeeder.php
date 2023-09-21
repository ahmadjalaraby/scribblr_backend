<?php

namespace Database\Seeders;

use App\Models\ArticleVisit;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $records = ArticleVisit::factory()->count(10_000)->make();

            $records->chunk(500)->each(function ($chunk) {
                ArticleVisit::insert($chunk->toArray());
            });
        }
    }
}
