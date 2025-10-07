<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Create New Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert message (if any) --}}
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-400 text-green-100 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-md backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 sm:rounded-3xl ring-1 ring-white/10">
                <h3 class="font-semibold text-lg text-white mb-4">
                    Add a New Movie:
                </h3>

                {{-- MovieForm component for creation --}}
                <x-movie-form
                    :action="route('movies.store')"
                    :method="'POST'"
                    class="bg-transparent text-white"
                />
            </div>
        </div>
    </div>
</x-app-layout>
