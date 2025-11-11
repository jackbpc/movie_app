<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Genre;

class MovieGenreSeeder extends Seeder
{
    public function run(): void
    {
        // Get all genres
        $genres = Genre::all();

        // Assign genres to each movie randomly or manually
        Movie::all()->each(function ($movie) use ($genres) {
            // Example: attach 1-3 random genres to each movie
            $movieGenres = $genres->random(rand(1, 3))->pluck('id');
            $movie->genres()->sync($movieGenres);
        });
    }
}
