<x-app-layout>
    <x-slot name="header">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Movies List') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-gray-900 to-black min-h-screen relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Black container holding all movies --}}
            <div class="bg-gray-900/90 rounded-3xl p-8 shadow-xl relative">

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="bg-green-600/20 border border-green-400 text-green-100 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-lg backdrop-blur-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Movie Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 items-stretch">
                    @forelse($movies as $movie)
                        <div 
                            class="group relative flex flex-col bg-gray-900/80 border border-gray-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 h-full cursor-pointer"
                            onclick="window.location='{{ route('movies.show', $movie) }}'"
                        >
                            <!-- Poster -->
                            <div class="aspect-[2/3] overflow-hidden rounded-t-2xl">
                                @if ($movie->image)
                                    <img src="{{ asset('images/' . $movie->image) }}" 
                                         alt="{{ $movie->title }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 rounded-t-2xl">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" 
                                         alt="No image" 
                                         class="w-full h-full object-cover opacity-70 rounded-t-2xl">
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex flex-col flex-grow p-5 min-h-[260px]">
                                <h3 class="text-2xl font-bold text-white truncate mb-3">
                                    {{ $movie->title }}
                                </h3>

                                {{-- Genres --}}
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach(explode(',', $movie->genre) as $genre)
                                        <span class="bg-purple-600/70 text-white text-sm font-medium px-3 py-1 rounded-full">
                                            {{ trim($genre) }}
                                        </span>
                                    @endforeach
                                </div>

                                {{-- Description --}}
                                <p class="text-base text-gray-300 mb-4 line-clamp-4">
                                    {{ $movie->description }}
                                </p>

                                <div class="mt-auto flex justify-between items-center">
                                    {{-- Display star rating --}}
                                    @php
                                        $avg = $movie->ratings->count() ? round($movie->ratings->avg('rating')) : 0;
                                    @endphp
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $avg)
                                                <span class="text-yellow-400 text-xl">★</span>
                                            @else
                                                <span class="text-gray-500 text-xl">★</span>
                                            @endif
                                        @endfor
                                    </div>

                                    {{-- Edit/Delete buttons for admins only --}}
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                        <div class="flex gap-2">
                                            <a href="{{ route('movies.edit', $movie) }}"
                                               onclick="event.stopPropagation()"
                                               class="px-3 py-1.5 text-sm font-medium bg-purple-600 hover:bg-purple-700 text-white rounded-md transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('movies.destroy', $movie) }}" method="POST"
                                                  onclick="event.stopPropagation();"
                                                  onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1.5 text-sm font-medium bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Lighter overlay on hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-2xl"></div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-300 py-20 text-lg font-semibold">
                            No movies found :(
                        </div>
                    @endforelse
                </div>

                {{-- Error Toast Modal at Top using Alpine.js --}}
                @if(session('error'))
                    <div x-data="{ open: true }" x-show="open" x-init="setTimeout(() => open = false, 5000)"
                         class="absolute top-4 left-1/2 transform -translate-x-1/2 z-50">
                        <div class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-4">
                            <span class="font-semibold">⚠️</span>
                            <span>{{ session('error') }}</span>
                            <button @click="open = false" class="ml-4 text-white font-bold hover:text-gray-200">&times;</button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
