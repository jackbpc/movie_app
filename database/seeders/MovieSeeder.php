<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Genre;
use Carbon\Carbon;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $currentTimestamp = Carbon::now();

        // Ensure all genres exist in the database
        $genresList = ['Action', 'Adventure', 'Sci-Fi', 'Drama', 'Thriller'];
        foreach ($genresList as $genreName) {
            Genre::firstOrCreate(['name' => $genreName]);
        }

        // Movies data with intended genre names
        $movies = [
            [
                'title' => 'The Dark Knight',
                'short_description' => 'Batman faces the Joker in Gotham City.',
                'long_description' => 'Batman must confront the chaotic Joker who threatens Gotham, testing his limits as a hero and forcing him to question his own moral code...',
                'image' => 'thedarkknight.jpg'
            ],
            [
                'title' => 'Inception',
                'short_description' => 'A thief steals secrets through dreams.',
                'long_description' => 'Dom Cobb is a skilled thief who infiltrates people’s dreams to extract information, but when tasked with planting an idea instead...',
                'image' => 'inception.jpg'
                
            ],
            [
                'title' => 'Parasite',
                'short_description' => 'A poor family infiltrates a wealthy household.',
                'long_description' => 'The Kim family cunningly integrates into the wealthy Park family’s home, leading to darkly comic and tragic consequences...',
                'image' => 'parasite.jpg'
            ],
            [
                'title' => 'Interstellar',
                'short_description' => 'Explorers travel through a wormhole to save humanity.',
                'long_description' => 'A team of astronauts embarks on a journey through space and time to find a habitable planet for humanity...',
                'image' => 'interstellar.jpg'
            ],
            [
                'title' => 'The Shawshank Redemption',
                'short_description' => 'Two men find hope in prison.',
                'long_description' => 'Over decades in Shawshank prison, Andy and Red forge a bond of friendship and hope...',
                'image' => 'theshawshankredemption.jpg'
            ],
            [
                'title' => 'Avengers: Endgame',
                'short_description' => 'Heroes unite to undo Thanos’ devastation.',
                'long_description' => 'After the devastating events of Infinity War, the remaining Avengers come together to reverse the snap...',
                'image' => 'avengersendgame.jpg'
            ],
            [
                'title' => 'The Matrix',
                'short_description' => 'A hacker discovers reality is a simulation.',
                'long_description' => 'Neo learns that the world he knows is a simulated reality controlled by machines...',
                'image' => 'thematrix.jpg'
            ],
            [
                'title' => 'Gone Girl',
                'short_description' => 'A man becomes the prime suspect in his wife’s disappearance.',
                'long_description' => 'When his wife goes missing, Nick faces mounting media pressure and police suspicion...',
                'image' => 'gonegirl.jpg'
            ],
            [
                'title' => 'Arrival',
                'short_description' => 'A linguist communicates with aliens.',
                'long_description' => 'When mysterious spacecraft appear on Earth, linguist Louise Banks works tirelessly to decode their language...',
                'image' => 'arrival.jpg'
            ],
            [
                'title' => 'Forrest Gump',
                'short_description' => 'A man witnesses historical events.',
                'long_description' => 'From childhood hardships to extraordinary moments in history, Forrest Gump’s innocent perspective and perseverance shape his remarkable journey...',
                'image' => 'forrestgump.jpg'
            ],
            [
                'title' => 'Mad Max: Fury Road',
                'short_description' => 'A woman rebels in a post-apocalyptic desert.',
                'long_description' => 'In a post-apocalyptic desert, Furiosa joins Max to rebel against a tyrannical warlord...',
                'image' => 'madmax.jpg'
            ],
            [
                'title' => 'John Wick',
                'short_description' => 'An ex-hitman seeks vengeance.',
                'long_description' => 'After gangsters kill his dog, John Wick comes out of retirement to hunt down those responsible...',
                'image' => 'johnwick.jpg'
            ],
            [
                'title' => 'Blade Runner 2049',
                'short_description' => 'A blade runner uncovers a dangerous secret.',
                'long_description' => 'K, a blade runner, uncovers a long-buried secret that threatens to destabilize society...',
                'image' => 'bladerunner.jpg'
            ],
            [
                'title' => 'Dune',
                'short_description' => 'A family fights for control of Arrakis.',
                'long_description' => 'House Atreides becomes embroiled in a deadly conflict over Arrakis, the galaxy’s most valuable planet...',
                'image' => 'dune.jpg'
            ],
            [
                'title' => 'Se7en',
                'short_description' => 'Detectives hunt a serial killer.',
                'long_description' => 'Two detectives track a serial killer who uses the seven deadly sins as inspiration for his crimes...',
                'image' => 'se7en.jpg'
            ],
            [
                'title' => 'Shutter Island',
                'short_description' => 'A marshal investigates a psychiatric facility.',
                'long_description' => 'U.S. Marshal Teddy Daniels investigates the disappearance of a patient on Shutter Island...',
                'image' => 'shutterisland.jpg'
            ],
            [
                'title' => 'The Revenant',
                'short_description' => 'A frontiersman fights for survival.',
                'long_description' => 'Hugh Glass is mauled by a bear and left for dead, battling the brutal wilderness and human threats to survive...',
                'image' => 'therevenant.jpg'
            ],
            [
                'title' => 'Jurassic Park',
                'short_description' => 'Dinosaurs escape the theme park.',
                'long_description' => 'Cloned dinosaurs break free from Jurassic Park’s enclosures, creating chaos...',
                'image' => 'jurassicpark.jpg'
            ],
            [
                'title' => 'The Godfather',
                'short_description' => 'The patriarch passes control of his empire.',
                'long_description' => 'The aging Don Vito Corleone transfers control of the family crime empire to his reluctant son Michael...',
                'image' => 'thegodfather.jpg'
            ],
            [
                'title' => 'Fight Club',
                'short_description' => 'Two men form an underground fight club.',
                'long_description' => 'An insomniac office worker and a soap maker start an underground fight club that spirals into chaos...',
                'image' => 'fightclub.jpg'
            ],
        ];

        foreach ($movies as $movieData) {
            $genres = $movieData['genres'] ?? [];
            unset($movieData['genres']);

            // Create movie
            $movie = Movie::create(array_merge($movieData, [
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ]));

            // Attach genres dynamically
            if (!empty($genres)) {
                $genreIds = Genre::whereIn('name', $genres)->pluck('id');
                $movie->genres()->attach($genreIds);
            }
        }

        $this->command->info('All movies seeded successfully with their correct genres!');
    }
}
