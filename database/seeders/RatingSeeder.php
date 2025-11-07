<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::all();
        $users = User::all();

        if ($movies->isEmpty()) {
            $this->command->warn('⚠️ No movies found. Run MovieSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->warn('⚠️ No users found. Run UserSeeder first.');
            return;
        }

        foreach ($movies as $movie) {
            // Decide how many unique users will rate this movie (1–5, but not more than total users)
            $numRatings = rand(3, min(5, $users->count()));
            

            // Pick that many distinct users
            $randomUsers = $users->random($numRatings);

            foreach ($randomUsers as $user) {
                try {
                    Rating::create([
                        'movie_id' => $movie->id,
                        'user_id' => $user->id,
                        'rating' => rand(1, 5),
                        'comment' => fake()->boolean(50) ? fake()->sentence() : null,
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    // Skip duplicate entries if seeder is run multiple times
                    continue;
                }
            }
        }

        $this->command->info('✅ Ratings seeded successfully!');
    }
}
