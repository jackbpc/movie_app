<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $currentTimestamp = Carbon::now();

        Movie::insert([
            // Existing Movies
            [
                'title' => 'The Dark Knight',
                'description' => 'Batman faces the Joker in Gotham City, testing his limits as a hero.',
                'genre' => 'Action',
                'image' => 'thedarkknight.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Inception',
                'description' => 'A skilled thief enters dreams to steal secrets, but faces unexpected challenges.',
                'genre' => 'Sci-Fi',
                'image' => 'inception.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Parasite',
                'description' => 'A poor family infiltrates a wealthy household, leading to unforeseen consequences.',
                'genre' => 'Thriller',
                'image' => 'parasite.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Interstellar',
                'description' => 'A team of explorers travel through a wormhole to save humanity.',
                'genre' => 'Adventure',
                'image' => 'interstellar.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'The Shawshank Redemption',
                'description' => 'Two imprisoned men bond over years, finding hope and redemption.',
                'genre' => 'Drama',
                'image' => 'theshawshankredemption.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Avengers: Endgame',
                'description' => 'Superheroes unite to undo the devastation caused by Thanos.',
                'genre' => 'Action',
                'image' => 'avengersendgame.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'The Matrix',
                'description' => 'A hacker discovers reality is a simulation and joins the rebellion.',
                'genre' => 'Sci-Fi',
                'image' => 'thematrix.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Gone Girl',
                'description' => 'A man becomes the prime suspect in his wife’s mysterious disappearance.',
                'genre' => 'Thriller',
                'image' => 'gonegirl.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Arrival',
                'description' => 'A linguist works to communicate with extraterrestrial visitors to prevent global conflict.',
                'genre' => 'Adventure',
                'image' => 'arrival.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Forrest Gump',
                'description' => 'The life story of a kind man who witnesses and influences historical events.',
                'genre' => 'Drama',
                'image' => 'forrestgump.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],

            [
                'title' => 'Mad Max: Fury Road',
                'description' => 'In a post-apocalyptic desert, a woman rebels against a tyrant, aided by a drifter named Max.',
                'genre' => 'Action',
                'image' => 'madmax.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'John Wick',
                'description' => 'An ex-hitman comes out of retirement to track down the gangsters who killed his dog.',
                'genre' => 'Action',
                'image' => 'johnwick.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],

            [
                'title' => 'Blade Runner 2049',
                'description' => 'A young blade runner unearths a long-buried secret that could alter humanity’s future.',
                'genre' => 'Sci-Fi',
                'image' => 'bladerunner.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Dune',
                'description' => 'A noble family becomes embroiled in a war for control of the galaxy’s most valuable resource.',
                'genre' => 'Sci-Fi',
                'image' => 'dune.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],

            [
                'title' => 'Se7en',
                'description' => 'Two detectives hunt a serial killer who uses the seven deadly sins as his motives.',
                'genre' => 'Thriller',
                'image' => 'se7en.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Shutter Island',
                'description' => 'A U.S. Marshal investigates a psychiatric facility where nothing is as it seems.',
                'genre' => 'Thriller',
                'image' => 'shutterisland.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],

            [
                'title' => 'The Revenant',
                'description' => 'A frontiersman fights for survival after being mauled by a bear and left for dead.',
                'genre' => 'Adventure',
                'image' => 'therevenant.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Jurassic Park',
                'description' => 'A theme park’s cloned dinosaurs escape and wreak havoc on the island.',
                'genre' => 'Adventure',
                'image' => 'jurassicpark.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],

            // Added Movies (Drama)
            [
                'title' => 'The Godfather',
                'description' => 'The aging patriarch of a crime family transfers control of his empire to his reluctant son.',
                'genre' => 'Drama',
                'image' => 'thegodfather.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'title' => 'Fight Club',
                'description' => 'An office worker and a soap maker form an underground fight club with dark consequences.',
                'genre' => 'Drama',
                'image' => 'fightclub.jpg',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
        ]);
    }
}
