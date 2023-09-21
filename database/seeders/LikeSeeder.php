<?php

namespace Database\Seeders;

use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = Like::factory()->count(100_000)->make();

        $records->chunk(500)->each(function ($chunk) {
            Like::insert($chunk->toArray());
        });
    }
}
