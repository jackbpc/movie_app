<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Movie;
use App\Models\Genre;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $currentTimestamp = Carbon::now();

        $moviesData = [
            [
                'title' => 'The Dark Knight',
                'short_description' => 'Batman faces the Joker in Gotham City.',
                'long_description' => 'Batman must confront the chaotic Joker who threatens Gotham, testing his limits as a hero and forcing him to question his own moral code. As the Joker escalates his reign of terror, alliances are strained, and Batman must navigate a city on the edge of collapse while balancing justice and vengeance.',
                'image' => 'thedarkknight.jpg',
                'genres' => ['Action']
            ],
            [
                'title' => 'Inception',
                'short_description' => 'A thief steals secrets through dreams.',
                'long_description' => 'Dom Cobb is a skilled thief who infiltrates people’s dreams to extract information. But when tasked with planting an idea instead, he faces psychological and existential challenges. As layers of dreams unfold, reality becomes increasingly uncertain, and Cobb must confront his own subconscious fears to succeed.',
                'image' => 'inception.jpg',
                'genres' => ['Sci-Fi']
            ],
            [
                'title' => 'Parasite',
                'short_description' => 'A poor family infiltrates a wealthy household.',
                'long_description' => 'The Kim family cunningly integrates into the wealthy Park family’s home, leading to darkly comic and tragic consequences that expose social inequality. Tensions rise as secrets are revealed, ultimately culminating in a shocking and unforgettable climax that changes everyone’s lives forever.',
                'image' => 'parasite.jpg',
                'genres' => ['Thriller', 'Drama']
            ],
            [
                'title' => 'Interstellar',
                'short_description' => 'Explorers travel through a wormhole to save humanity.',
                'long_description' => 'A team of astronauts embarks on a journey through space and time to find a habitable planet for humanity, confronting scientific and emotional challenges along the way. As they traverse distant worlds and encounter unforeseen dangers, the crew must make impossible choices, testing the bonds of love, loyalty, and survival.',
                'image' => 'interstellar.jpg',
                'genres' => ['Adventure', 'Sci-Fi']
            ],
            [
                'title' => 'The Shawshank Redemption',
                'short_description' => 'Two men find hope in prison.',
                'long_description' => 'Over decades in Shawshank prison, Andy and Red forge a bond of friendship and hope, defying the oppressive system around them. Through resilience, cleverness, and unwavering optimism, they navigate hardship and injustice, ultimately discovering redemption and freedom in unexpected ways.',
                'image' => 'theshawshankredemption.jpg',
                'genres' => ['Drama']
            ],
            [
                'title' => 'Avengers: Endgame',
                'short_description' => 'Heroes unite to undo Thanos’ devastation.',
                'long_description' => 'After the devastating events of Infinity War, the remaining Avengers come together to reverse the snap and face their greatest challenge yet. Through time travel, personal sacrifice, and heroic teamwork, they fight against overwhelming odds to restore hope to the universe and honor fallen comrades.',
                'image' => 'avengersendgame.jpg',
                'genres' => ['Action', 'Adventure']
            ],
            [
                'title' => 'The Matrix',
                'short_description' => 'A hacker discovers reality is a simulation.',
                'long_description' => 'Neo learns that the world he knows is a simulated reality controlled by machines. He joins a rebellion to fight for humanity’s freedom, mastering skills beyond imagination and uncovering profound truths about choice, destiny, and reality itself.',
                'image' => 'thematrix.jpg',
                'genres' => ['Sci-Fi', 'Action']
            ],
            [
                'title' => 'Gone Girl',
                'short_description' => 'A man becomes the prime suspect in his wife’s disappearance.',
                'long_description' => 'When his wife goes missing, Nick faces mounting media pressure and police suspicion, revealing dark secrets and twisted truths about their marriage. Each revelation deepens the psychological tension, leading to shocking twists that keep everyone guessing until the very end.',
                'image' => 'gonegirl.jpg',
                'genres' => ['Thriller']
            ],
            [
                'title' => 'Arrival',
                'short_description' => 'A linguist communicates with aliens.',
                'long_description' => 'When mysterious spacecraft appear on Earth, linguist Louise Banks works tirelessly to decode their language and prevent global conflict. As she unravels their complex communication, she discovers profound insights about time, memory, and the human experience, which challenge her perception of reality.',
                'image' => 'arrival.jpg',
                'genres' => ['Adventure', 'Sci-Fi']
            ],
            [
                'title' => 'Forrest Gump',
                'short_description' => 'A man witnesses historical events.',
                'long_description' => 'From childhood hardships to extraordinary moments in history, Forrest Gump’s innocent perspective and perseverance shape his remarkable journey through life and love. Through chance encounters, personal triumphs, and unexpected adventures, Forrest’s story reveals the beauty of simplicity and the power of kindness.',
                'image' => 'forrestgump.jpg',
                'genres' => ['Drama']
            ],
            [
                'title' => 'Mad Max: Fury Road',
                'short_description' => 'A woman rebels in a post-apocalyptic desert.',
                'long_description' => 'In a post-apocalyptic desert, Furiosa joins Max to rebel against a tyrannical warlord, navigating high-octane chases and dangerous alliances. Together, they fight for survival, liberation, and a chance to reclaim humanity in a world ruled by chaos.',
                'image' => 'madmax.jpg',
                'genres' => ['Action', 'Adventure']
            ],
            [
                'title' => 'John Wick',
                'short_description' => 'An ex-hitman seeks vengeance.',
                'long_description' => 'After gangsters kill his dog, John Wick comes out of retirement to hunt down those responsible. His relentless pursuit unleashes a stylized and intense wave of action, while he faces moral dilemmas, old enemies, and an underworld code of honor.',
                'image' => 'johnwick.jpg',
                'genres' => ['Action']
            ],
            [
                'title' => 'Blade Runner 2049',
                'short_description' => 'A blade runner uncovers a dangerous secret.',
                'long_description' => 'K, a blade runner, uncovers a long-buried secret that threatens to destabilize society. As he investigates, he confronts philosophical questions about identity, memory, and what it means to be human, all while navigating a visually stunning dystopian world.',
                'image' => 'bladerunner.jpg',
                'genres' => ['Sci-Fi', 'Thriller']
            ],
            [
                'title' => 'Dune',
                'short_description' => 'A family fights for control of Arrakis.',
                'long_description' => 'House Atreides becomes embroiled in a deadly conflict over Arrakis, the galaxy’s most valuable planet. Political intrigue, betrayal, and the harsh desert environment challenge the family as they confront destiny, power, and survival on this epic scale.',
                'image' => 'dune.jpg',
                'genres' => ['Sci-Fi', 'Adventure']
            ],
            [
                'title' => 'Se7en',
                'short_description' => 'Detectives hunt a serial killer.',
                'long_description' => 'Two detectives track a serial killer who uses the seven deadly sins as inspiration for his crimes. As the investigation intensifies, they navigate moral ambiguity and psychological horror, culminating in a haunting and unforgettable conclusion.',
                'image' => 'se7en.jpg',
                'genres' => ['Thriller', 'Drama']
            ],
            [
                'title' => 'Shutter Island',
                'short_description' => 'A marshal investigates a psychiatric facility.',
                'long_description' => 'U.S. Marshal Teddy Daniels investigates the disappearance of a patient on Shutter Island. As he digs deeper, unsettling secrets emerge, blurring the line between reality and delusion and forcing him to confront his own traumatic past.',
                'image' => 'shutterisland.jpg',
                'genres' => ['Thriller', 'Mystery']
            ],
            [
                'title' => 'The Revenant',
                'short_description' => 'A frontiersman fights for survival.',
                'long_description' => 'Hugh Glass is mauled by a bear and left for dead, battling the brutal wilderness and human threats to survive. Driven by determination and revenge, he navigates unforgiving terrain in a raw and relentless fight for life and justice.',
                'image' => 'therevenant.jpg',
                'genres' => ['Adventure', 'Drama']
            ],
            [
                'title' => 'Jurassic Park',
                'short_description' => 'Dinosaurs escape the theme park.',
                'long_description' => 'Cloned dinosaurs break free from Jurassic Park’s enclosures, creating chaos and endangering human lives. Scientists and visitors struggle to survive while confronting the unpredictable power of nature and the consequences of playing god.',
                'image' => 'jurassicpark.jpg',
                'genres' => ['Adventure', 'Sci-Fi']
            ],
            [
                'title' => 'The Godfather',
                'short_description' => 'The patriarch passes control of his empire.',
                'long_description' => 'The aging Don Vito Corleone transfers control of the family crime empire to his reluctant son Michael. Navigating loyalty, betrayal, and power struggles, Michael must learn the harsh realities of leadership and the burdens of family legacy.',
                'image' => 'thegodfather.jpg',
                'genres' => ['Drama', 'Crime']
            ],
            [
                'title' => 'Fight Club',
                'short_description' => 'Two men form an underground fight club.',
                'long_description' => 'An insomniac office worker and a soap maker start an underground fight club that spirals into chaos. As identities blur and societal norms are challenged, the story explores rebellion, masculinity, and the struggle for meaning in a consumer-driven world.',
                'image' => 'fightclub.jpg',
                'genres' => ['Drama']
            ],
        ];

        foreach ($moviesData as $movieData) {
            $genres = $movieData['genres'];
            unset($movieData['genres']);

            $movie = Movie::create(array_merge($movieData, [
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ]));

            $genreIds = Genre::whereIn('name', $genres)->pluck('id');
            $movie->genres()->attach($genreIds);
        }
    }
}
