<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            TagSeeder::class,
            UserSeeder::class,
            ArticleSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class,
            FollowSeeder::class,
            BookmarkSeeder::class,
            ArticleVisitSeeder::class,
        ]);

        User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => '.',
            'email' => 'admin@admin.com',
        ]);
    }
}
