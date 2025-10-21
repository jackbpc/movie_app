<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Edit Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success message --}}
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-400 text-green-100 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-md backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-600/20 border border-red-400 text-red-100 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-md backdrop-blur-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form container --}}
            <div class="p-6 sm:rounded-3xl ring-1 ring-white/10 bg-transparent">
                <h3 class="font-semibold text-lg text-white mb-4">
                    Edit Movie:
                </h3>

                {{-- Use the unified MovieForm component --}}
                <x-movie-form
                    :action="route('movies.update', $movie)"
                    :method="'PUT'"
                    :movie="$movie"
                    class="bg-transparent text-white"
                />
            </div>
        </div>
    </div>
</x-app-layout>
