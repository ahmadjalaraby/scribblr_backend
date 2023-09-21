<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $records = Bookmark::factory()->count(10_000)->make();

            $records->chunk(500)->each(function ($chunk) {
                Bookmark::insert($chunk->toArray());
            });
        }
    }
}
