<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\User; // optional if you want to assign random users
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all movies
        $movies = Movie::all();

        // Optional: get all users if you want to associate ratings with a user
        $users = User::all();

        foreach ($movies as $movie) {

            // Random number of ratings per movie (3-5)
            $numRatings = rand(3, 5);

            for ($i = 0; $i < $numRatings; $i++) {
                Rating::create([
                    'movie_id' => $movie->id,
                    'user_id' => $users->isNotEmpty() ? $users->random()->id : null, // optional user
                    'rating' => rand(1, 5),
                    'comment' => rand(0, 1) ? fake()->sentence() : null,
                ]);
            }
        }
    }
}
