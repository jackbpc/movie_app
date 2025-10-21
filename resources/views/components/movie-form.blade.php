@props([
    'action',
    'method' => 'POST',
    'movie' => null,
    'class' => ''
])

@php
    // Reusable input classes with !important to override global CSS
    $inputClasses = "
        w-full p-3 rounded-lg
        !bg-gray-800 !border !border-gray-700
        text-white placeholder-gray-400
        focus:!outline-none focus:!ring-2 focus:!ring-blue-500 focus:!border-blue-500
    ";
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="{{ $class }}">
    @csrf
    @if($method === 'PUT' || $method === 'PATCH')
        @method($method)
    @endif

    <div class="space-y-4">
        {{-- Title --}}
        <div>
            <label for="title" class="block mb-1 text-white font-semibold">Title</label>
            <input
                type="text"
                name="title"
                id="title"
                value="{{ old('title', $movie->title ?? '') }}"
                placeholder="Title goes here..."
                class="{{ $inputClasses }}"
            >
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block mb-1 text-white font-semibold">Description</label>
            <textarea
                name="description"
                id="description"
                rows="4"
                placeholder="Enter the movie description..."
                class="{{ $inputClasses }}"
            >{{ old('description', $movie->description ?? '') }}</textarea>
        </div>

        {{-- Genre --}}
        <div>
            <label for="genre" class="block mb-1 text-white font-semibold">Genre</label>
            <input
                type="text"
                name="genre"
                id="genre"
                value="{{ old('genre', $movie->genre ?? '') }}"
                placeholder="e.g. Comedy, Drama..."
                class="{{ $inputClasses }}"
            >
        </div>

        {{-- Rating --}}
        <div>
            <label for="rating" class="block mb-1 text-white font-semibold">Rating</label>
            <input
                type="number"
                step="0.1"
                name="rating"
                id="rating"
                value="{{ old('rating', $movie->rating ?? '') }}"
                placeholder="0–5"
                class="{{ $inputClasses }}"
            >
        </div>

        {{-- Poster Upload --}}
        <div>
            <label for="image" class="block mb-1 text-white font-semibold">Poster Image</label>
            <input
                type="file"
                name="image"
                id="image"
                class="w-full p-2 text-gray-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-700 file:text-sm file:font-semibold file:bg-gray-700 file:text-white hover:file:bg-gray-600"
            >

            @if(isset($movie) && $movie->image)
                <div x-data="{ open: false }" class="mt-4">
                    <p class="text-gray-200 font-semibold mb-2">Current Poster:</p>
                    <img
                        src="{{ asset('images/' . $movie->image) }}"
                        alt="{{ $movie->title }}"
                        class="w-40 rounded-lg shadow-md border border-gray-700 cursor-pointer transition-transform duration-300 hover:scale-105"
                        @click="open = true"
                    >

                    <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50" @click="open = false">
                        <img
                            src="{{ asset('images/' . $movie->image) }}"
                            alt="{{ $movie->title }}"
                            class="max-h-[90%] max-w-[90%] rounded-lg shadow-xl transform transition-transform duration-500 hover:scale-110"
                            @click.stop
                        >
                    </div>
                </div>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-between mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                {{ $method === 'PUT' ? 'Update Movie' : 'Create Movie' }}
            </button>

            <a href="{{ route('movies.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                Cancel
            </a>
        </div>
    </div>
</form>

<script src="//unpkg.com/alpinejs" defer></script>
