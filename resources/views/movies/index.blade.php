<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Movies List') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl space-y-8 px-4 md:px-0">

        {{-- Success / Error Messages --}}
        @if(session('success'))
            <div class="bg-green-600/20 border border-green-400 text-green-100 px-6 py-4 rounded-lg text-center font-semibold shadow-lg backdrop-blur-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-600/20 border border-red-400 text-red-100 px-6 py-4 rounded-lg text-center font-semibold shadow-lg backdrop-blur-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Movie Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8 items-stretch">
            @forelse($movies as $movie)
                <div 
                    class="group relative flex flex-col bg-gray-800/70 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 h-full cursor-pointer"
                    onclick="window.location='{{ route('movies.show', $movie) }}'">
                    
                    {{-- Poster --}}
                    <div class="aspect-[2/3] overflow-hidden rounded-t-2xl">
                        <img src="{{ $movie->image ? asset('images/' . $movie->image) : asset('images/placeholder.jpg') }}" 
                             alt="{{ $movie->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 rounded-t-2xl">
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col flex-grow p-4 md:p-5 min-h-[260px]">
                        {{-- Title --}}
                        <h3 class="text-xl md:text-2xl font-bold text-white truncate mb-2">
                            {{ $movie->title }}
                        </h3>

                        {{-- Genres --}}
                        <div class="flex flex-wrap gap-2 mb-2 md:mb-3">
                            @foreach($movie->genres as $genre)
                                <span class="bg-purple-600/70 text-white text-xs md:text-sm font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $genre->name }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Short Description --}}
                        <p class="text-gray-300 text-sm md:text-base mb-3 line-clamp-4">
                            {{ $movie->short_description }}
                        </p>

                        {{-- Rating & Admin Controls --}}
                        <div class="mt-auto flex justify-between items-center">
                            
                            {{-- Star rating logic --}}
                            @php
                                // Calculate average rating, but also check the count
                                $ratingCount = $movie->ratings->count();
                                $avg = $ratingCount > 0 ? round($movie->ratings->avg('rating')) : 0;
                            @endphp

                            @if ($ratingCount > 0)
                                {{-- Display Stars (If there are ratings) --}}
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $avg)
                                            <span class="text-yellow-400 text-lg md:text-xl">★</span>
                                        @else
                                            <span class="text-gray-500 text-lg md:text-xl">★</span>
                                        @endif
                                    @endfor
                                </div>
                            @else
                                {{-- Display "No reviews yet" (If there are NO ratings) --}}
                                <div class="text-gray-400 text-sm italic font-medium">
                                    No reviews yet
                                </div>
                            @endif
                            
                            {{-- Admin Edit/Delete --}}
                            @if(Auth::check() && Auth::user()->role === 'admin')
                                <div class="flex gap-2">
                                    <a href="{{ route('movies.edit', $movie) }}"
                                       onclick="event.stopPropagation()"
                                       class="px-2.5 py-1 text-xs md:text-sm font-medium bg-purple-600 hover:bg-purple-700 text-white rounded-md transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('movies.destroy', $movie) }}" method="POST"
                                          onclick="event.stopPropagation();"
                                          onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-2.5 py-1 text-xs md:text-sm font-medium bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Hover overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-2xl"></div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-300 py-16 md:py-20 text-lg font-semibold">
                    No movies found :(
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
