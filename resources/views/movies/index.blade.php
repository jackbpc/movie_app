<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movies List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Movies List</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($movies as $movie)
                    <a href="{{ route('movies.show', $movie) }}">
                        <x-movie-card :movie="$movie" />
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
