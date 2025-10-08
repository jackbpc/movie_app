<x-app-layout>

    <div class="py-12 bg-gradient-to-b from-gray-900 to-black min-h-screen rounded-3xl">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Movie Card -->
            <div class="bg-gray-900/80 rounded-2xl shadow-lg overflow-hidden border border-gray-700">

                <!-- Movie Title -->
                <div class="bg-gray-800/70 p-6 text-center">
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                        {{ $movie->title }}
                    </h1>
                </div>

                <!-- Movie Poster Image -->
                @if($movie->image)
                <div class="overflow-hidden flex justify-center mt-4 px-6">
                    <img src="{{ asset('images/' . $movie->image) }}" 
                         alt="{{ $movie->title }}" 
                         class="w-full max-w-md h-auto object-cover rounded-xl shadow-lg transition-transform duration-500 hover:scale-105">
                </div>
                @endif

                <!-- Genres -->
                <div class="flex flex-wrap justify-center gap-2 mt-4 px-6">
                    @foreach(explode(',', $movie->genre) as $genre)
                        <span class="bg-purple-600/70 text-white text-xs font-medium px-3 py-1 rounded-full">
                            {{ trim($genre) }}
                        </span>
                    @endforeach
                </div>

                <!-- Movie Description -->
                <div class="p-6 text-gray-300 leading-relaxed text-lg">
                    <p>{{ $movie->description ?? 'No description available.' }}</p>
                </div>

                <!-- Movie Metadata Footer -->
                <div class="bg-gray-800/70 p-6 border-t border-gray-700 flex flex-col sm:flex-row justify-between items-center text-white font-semibold gap-4">
                    <span>
                        <strong>Genre:</strong> {{ $movie->genre ?? 'Unknown' }}
                    </span>
                    <span class="text-yellow-400">
                        ⭐ {{ $movie->rating ?? 'N/A' }}/5
                    </span>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
