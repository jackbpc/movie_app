<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Movies List') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-gray-900 to-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-400 text-green-100 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-lg backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Movie Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 items-stretch">
                @foreach($movies as $movie)
                    <div 
                        class="group relative flex flex-col bg-gray-900/80 border border-gray-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 h-full cursor-pointer"
                        onclick="window.location='{{ route('movies.show', $movie) }}'"
                    >
                        <!-- Poster -->
                        <div class="aspect-[2/3] overflow-hidden">
                            @if ($movie->image)
                                <img src="{{ asset('images/' . $movie->image) }}" 
                                     alt="{{ $movie->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <img src="{{ asset('images/placeholder.jpg') }}" 
                                     alt="No image" 
                                     class="w-full h-full object-cover opacity-70">
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex flex-col flex-grow p-5 min-h-[240px]">
                            <h3 class="text-xl font-bold text-white truncate mb-2">
                                {{ $movie->title }}
                            </h3>

                            {{-- Genres --}}
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach(explode(',', $movie->genre) as $genre)
                                    <span class="bg-purple-600/70 text-white text-xs font-medium px-2 py-0.5 rounded-full">
                                        {{ trim($genre) }}
                                    </span>
                                @endforeach
                            </div>

                            <p class="text-sm text-gray-300 mb-4 line-clamp-4">
                                {{ $movie->description }}
                            </p>

                            <div class="mt-auto flex justify-between items-center">
                                {{-- Display rating out of 5 --}}
                                @if(is_numeric($movie->rating))
                                    <span class="text-yellow-400 font-semibold">
                                        ⭐ {{ $movie->rating }}/5
                                    </span>
                                @endif

                                <!-- Edit/Delete buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('movies.edit', $movie) }}"
                                       onclick="event.stopPropagation()"
                                       class="px-3 py-1.5 text-sm font-medium bg-purple-600 hover:bg-purple-700 text-white rounded-md transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('movies.destroy', $movie) }}" method="POST"
                                          onsubmit="event.stopPropagation(); return confirm('Are you sure you want to delete this movie?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 text-sm font-medium bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Lighter overlay on hover (pointer-events fix) -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
