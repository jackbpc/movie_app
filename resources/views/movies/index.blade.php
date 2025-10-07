<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Movies List') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert message aligned with grid, text centered --}}
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-400 text-green-100 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-md backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-lg overflow-hidden flex flex-col hover:shadow-2xl transition-shadow duration-300 rounded-2xl">
                        <!-- Movie Content: Rounded only on top -->
                        <a href="{{ route('movies.show', $movie) }}" class="block">
                            <x-movie-card :movie="$movie" class="rounded-t-lg" />
                        </a>

                        <!-- Buttons: flat bottom -->
                        <div class="mt-auto flex justify-between p-4 bg-white/10 border-t border-white/20">
                            <a href="{{ route('movies.edit', $movie) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md transition-colors">
                                Edit
                            </a>

                            <form action="{{ route('movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
