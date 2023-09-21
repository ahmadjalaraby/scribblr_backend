<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $records = Comment::factory()->count(10_000)->make();

            $records->chunk(500)->each(function ($chunk) {
                Comment::insert($chunk->toArray());
            });
        }
    }
}
