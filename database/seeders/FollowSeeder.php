<?php

namespace Database\Seeders;

use App\Models\Follow;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = Follow::factory()->count(10_000)->make();

        $records->chunk(500)->each(function ($chunk) {
            Follow::insert($chunk->toArray());
        });
    }
}
