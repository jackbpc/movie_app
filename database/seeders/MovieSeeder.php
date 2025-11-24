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

        // Movies data
        $movies = [
            [
                'title' => 'The Dark Knight',
                'short_description' => 'Batman faces the Joker in Gotham City.',
                'long_description' => 'Batman must confront the chaotic Joker who threatens Gotham. As the city descends into anarchy, he is forced to confront his own moral limits. The battle between order and chaos pushes everyone to the edge, testing loyalty, courage, and justice.',
                'image' => 'thedarkknight.jpg'
            ],
            [
                'title' => 'Inception',
                'short_description' => 'A thief steals secrets through dreams.',
                'long_description' => 'Dom Cobb infiltrates people’s dreams to steal secrets. When tasked with planting an idea, he assembles a skilled team. The lines between reality and dreams blur, challenging his perception of truth and threatening his own psyche.',
                'image' => 'inception.jpg'
            ],
            [
                'title' => 'Parasite',
                'short_description' => 'A poor family infiltrates a wealthy household.',
                'long_description' => 'The Kim family cleverly integrates into the Park family’s home. Their scheme starts as harmless fun but soon spirals into dark consequences. Social tensions, jealousy, and desperation collide in a story that mixes comedy with tragedy.',
                'image' => 'parasite.jpg'
            ],
            [
                'title' => 'Interstellar',
                'short_description' => 'Explorers travel through a wormhole to save humanity.',
                'long_description' => 'Astronauts journey through space and time to find a habitable planet. Facing cosmic anomalies and personal sacrifices, they must push humanity’s limits. Every choice carries profound consequences for Earth and those they love.',
                'image' => 'interstellar.jpg'
            ],
            [
                'title' => 'The Shawshank Redemption',
                'short_description' => 'Two men find hope in prison.',
                'long_description' => 'Andy and Red form a deep bond in Shawshank prison. Over decades, they endure corruption, injustice, and despair. Their story is a powerful exploration of hope, friendship, and resilience.',
                'image' => 'theshawshankredemption.jpg'
            ],
            [
                'title' => 'Avengers: Endgame',
                'short_description' => 'Heroes unite to undo Thanos’ devastation.',
                'long_description' => 'After the catastrophic events of Infinity War, the Avengers regroup to undo the snap. They face challenges across time and space, making sacrifices that test their courage. The fate of the universe rests on their unity and determination.',
                'image' => 'avengersendgame.jpg'
            ],
            [
                'title' => 'The Matrix',
                'short_description' => 'A hacker discovers reality is a simulation.',
                'long_description' => 'Neo discovers the world he knows is a simulated reality controlled by machines. Guided by Morpheus, he embraces his destiny as The One. He must challenge both human and machine forces to liberate minds.',
                'image' => 'thematrix.jpg'
            ],
            [
                'title' => 'Gone Girl',
                'short_description' => 'A man becomes the prime suspect in his wife’s disappearance.',
                'long_description' => 'Nick faces scrutiny when his wife Amy vanishes. The media frenzy intensifies, and secrets are revealed. Dark twists and manipulations turn the investigation into a suspenseful and twisted narrative.',
                'image' => 'gonegirl.jpg'
            ],
            [
                'title' => 'Arrival',
                'short_description' => 'A linguist communicates with aliens.',
                'long_description' => 'When mysterious spacecraft appear, linguist Louise Banks deciphers their language. The process reveals profound insights about time, memory, and choice. Humanity’s future may depend on understanding these enigmatic visitors.',
                'image' => 'arrival.jpg'
            ],
            [
                'title' => 'Forrest Gump',
                'short_description' => 'A man witnesses historical events.',
                'long_description' => 'Forrest Gump experiences major historical moments with innocence and wonder. From childhood struggles to love, loss, and heroism, his journey is filled with extraordinary events. His perspective demonstrates how life is unpredictable yet meaningful.',
                'image' => 'forrestgump.jpg'
            ],
            [
                'title' => 'Mad Max: Fury Road',
                'short_description' => 'A woman rebels in a post-apocalyptic desert.',
                'long_description' => 'In a barren desert, Furiosa helps Max rebel against a tyrannical warlord. They embark on a high-octane chase across wastelands. Survival, trust, and redemption drive every brutal encounter.',
                'image' => 'madmax.jpg'
            ],
            [
                'title' => 'John Wick',
                'short_description' => 'An ex-hitman seeks vengeance.',
                'long_description' => 'After gangsters kill his dog, John Wick emerges from retirement to exact revenge. His pursuit is relentless, precise, and violent. The underworld is shaken by his return, as loyalty and betrayal collide.',
                'image' => 'johnwick.jpg'
            ],
            [
                'title' => 'Blade Runner 2049',
                'short_description' => 'A blade runner uncovers a dangerous secret.',
                'long_description' => 'K, a blade runner, discovers a secret that could destabilize society. He embarks on a journey to uncover the truth, questioning humanity, memory, and identity. Every step takes him closer to shocking revelations.',
                'image' => 'bladerunner.jpg'
            ],
            [
                'title' => 'Dune',
                'short_description' => 'A family fights for control of Arrakis.',
                'long_description' => 'House Atreides is caught in political intrigue over Arrakis. Amid desert battles, betrayal, and prophecy, Paul Atreides rises to challenge his fate. The planet’s survival and its people hang in the balance.',
                'image' => 'dune.jpg'
            ],
            [
                'title' => 'Se7en',
                'short_description' => 'Detectives hunt a serial killer.',
                'long_description' => 'Detectives Somerset and Mills track a serial killer inspired by the seven deadly sins. Each crime is meticulously planned to shock and disturb. Tension, suspense, and moral dilemmas escalate toward a devastating climax.',
                'image' => 'se7en.jpg'
            ],
            [
                'title' => 'Shutter Island',
                'short_description' => 'A marshal investigates a psychiatric facility.',
                'long_description' => 'U.S. Marshal Teddy Daniels investigates a missing patient at Shutter Island. As he delves deeper, he uncovers secrets that challenge his sanity. The line between reality and delusion blurs in a tense psychological thriller.',
                'image' => 'shutterisland.jpg'
            ],
            [
                'title' => 'The Revenant',
                'short_description' => 'A frontiersman fights for survival.',
                'long_description' => 'Hugh Glass is mauled by a bear and left for dead. Battling harsh wilderness and relentless enemies, he seeks revenge. Survival and determination drive him through brutal, unforgiving landscapes.',
                'image' => 'therevenant.jpg'
            ],
            [
                'title' => 'Jurassic Park',
                'short_description' => 'Dinosaurs escape the theme park.',
                'long_description' => 'When dinosaurs break free from their enclosures, chaos erupts in Jurassic Park. Scientists and visitors must survive as nature’s power proves unpredictable. Adventure and terror collide at every turn.',
                'image' => 'jurassicpark.jpg'
            ],
            [
                'title' => 'The Godfather',
                'short_description' => 'The patriarch passes control of his empire.',
                'long_description' => 'Don Vito Corleone transfers leadership of his crime family to Michael. As Michael navigates loyalty, betrayal, and power, the family legacy hangs in the balance. Violence and honor intertwine in a gripping saga.',
                'image' => 'thegodfather.jpg'
            ],
            [
                'title' => 'Fight Club',
                'short_description' => 'Two men form an underground fight club.',
                'long_description' => 'An insomniac office worker and a soap maker create a secret fight club. The club escalates into chaos and challenges societal norms. Identity, freedom, and destruction collide in unexpected ways.',
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

        $this->command->info('All movies seeded successfully with long descriptions!');
    }
}
