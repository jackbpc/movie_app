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

                <form 
                    action="{{ route('movies.update', $movie) }}" 
                    method="POST" 
                    enctype="multipart/form-data" 
                    class="space-y-6"
                >
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-white">Title</label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title', $movie->title) }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black"
                        >
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-white">Description</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black"
                        >{{ old('description', $movie->description) }}</textarea>
                    </div>

                    {{-- Genre --}}
                    <div>
                        <label for="genre" class="block text-sm font-medium text-white">Genre</label>
                        <input 
                            type="text" 
                            name="genre" 
                            id="genre" 
                            value="{{ old('genre', $movie->genre) }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black"
                        >
                    </div>

                    {{-- Rating --}}
                    <div>
                        <label for="rating" class="block text-sm font-medium text-white">Rating</label>
                        <input 
                            type="number" 
                            name="rating" 
                            id="rating" 
                            step="0.1" 
                            value="{{ old('rating', $movie->rating) }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black"
                        >
                    </div>

                    {{-- Image preview and upload --}}
                    <div class="mb-4" x-data="{ open: false }" @keydown.escape.window="open = false">
                        <span class="block text-sm font-medium text-white mb-2">Current Poster:</span>

                        @if($movie->image)
                            <!-- Thumbnail with cache-busting -->
                            <img 
                                src="{{ asset('images/' . $movie->image) }}?{{ time() }}" 
                                alt="Movie Poster" 
                                class="w-48 h-auto rounded-lg mb-2 shadow-md cursor-pointer transform transition-transform duration-300 hover:scale-105"
                                @click="open = true"
                            >

                            <!-- Modal / Lightbox -->
                            <div 
                                x-show="open" 
                                x-transition.opacity
                                class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
                                @click.outside="open = false"
                            >
                                <img 
                                    src="{{ asset('images/' . $movie->image) }}?{{ time() }}" 
                                    alt="Movie Poster Large" 
                                    class="max-w-full max-h-full rounded-lg shadow-lg"
                                >
                            </div>
                        @else
                            <img 
                                src="{{ asset('images/placeholder.jpg') }}" 
                                alt="No Poster" 
                                class="w-48 h-auto rounded-lg mb-2 shadow-md"
                            >
                        @endif

                        {{-- File input --}}
                        <label class="block text-sm font-medium text-white mt-2">
                            Choose Poster:
                            <input 
                                type="file" 
                                name="image" 
                                class="mt-2 block w-full text-sm text-gray-200 file:bg-gray-700 file:text-white file:border-0 file:rounded-md file:py-2 file:px-4 hover:file:bg-gray-600"
                            >
                        </label>
                    </div>

                    {{-- Submit & Cancel buttons --}}
                    <div class="flex space-x-4 mt-4">
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-yellow-500 text-black font-semibold rounded-lg hover:bg-yellow-600"
                        >
                            Update Movie
                        </button>

                        <a 
                            href="{{ route('movies.index') }}" 
                            class="px-4 py-2 bg-gray-700 text-white font-semibold rounded-lg hover:bg-gray-800"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alpine.js for modal functionality --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
