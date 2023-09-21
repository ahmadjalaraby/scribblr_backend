<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = User::factory()->count(3000)->make();

        $records->chunk(500)->each(function (Collection $chunk) {
            User::insert($chunk->toArray());
        });
    }
}
