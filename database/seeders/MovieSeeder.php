<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
// Call the Movie model in.
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $currentTimestamp = Carbon::now();

        Movie::insert([
            // Original 5 movies
            [
                'title' => 'The Dark Knight',
                'description' => 'Batman faces the Joker in Gotham City, testing his limits as a hero.',
                'genre' => 'Action',
                'rating' => 9.0,
                'image' => 'thedarkknight.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Inception',
                'description' => 'A skilled thief enters dreams to steal secrets, but faces unexpected challenges.',
                'genre' => 'Sci-Fi',
                'rating' => 8.8,
                'image' => 'inception.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Parasite',
                'description' => 'A poor family infiltrates a wealthy household, leading to unforeseen consequences.',
                'genre' => 'Thriller',
                'rating' => 8.6,
                'image' => 'parasite.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Interstellar',
                'description' => 'A team of explorers travel through a wormhole to save humanity.',
                'genre' => 'Adventure',
                'rating' => 8.6,
                'image' => 'interstellar.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'The Shawshank Redemption',
                'description' => 'Two imprisoned men bond over years, finding hope and redemption.',
                'genre' => 'Drama',
                'rating' => 9.3,
                'image' => 'theshawshankredemption.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],

            [
                'title' => 'Avengers: Endgame',
                'description' => 'Superheroes unite to undo the devastation caused by Thanos.',
                'genre' => 'Action',
                'rating' => 8.4,
                'image' => 'avengersendgame.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'The Matrix',
                'description' => 'A hacker discovers reality is a simulation and joins the rebellion.',
                'genre' => 'Sci-Fi',
                'rating' => 8.7,
                'image' => 'thematrix.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Gone Girl',
                'description' => 'A man becomes the prime suspect in his wife’s mysterious disappearance.',
                'genre' => 'Thriller',
                'rating' => 8.1,
                'image' => 'gonegirl.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Arrival',
                'description' => 'A linguist works to communicate with extraterrestrial visitors to prevent global conflict.',
                'genre' => 'Adventure',
                'rating' => 7.9,
                'image' => 'arrival.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Forrest Gump',
                'description' => 'The life story of a kind man who witnesses and influences historical events.',
                'genre' => 'Drama',
                'rating' => 8.8,
                'image' => 'forrestgump.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
        ]);
    }
}
