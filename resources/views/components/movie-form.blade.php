@props([
    'action',
    'method' => 'POST',
    'movie' => null,
    'class' => ''
])

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
                class="w-full p-3 rounded-lg bg-white text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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
                class="w-full p-3 rounded-lg bg-white text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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
                placeholder="e.g. Comedy, Drama, Action..."
                class="w-full p-3 rounded-lg bg-white text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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
                placeholder="Enter a rating between 0 and 10"
                class="w-full p-3 rounded-lg bg-white text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
        </div>

        {{-- Image upload --}}
        <div>
            <label for="image" class="block mb-1 text-white font-semibold">Poster Image</label>
            <input
                type="file"
                name="image"
                id="image"
                class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                       file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700"
            >

            {{-- Show old image preview if editing --}}
            @if(isset($movie) && $movie->image)
                <div class="mt-4">
                    <p class="text-white font-semibold mb-2">Current Poster:</p>
                    <img src="{{ asset('storage/' . $movie->image) }}" alt="Movie Poster" class="w-40 rounded-lg shadow-md border border-white/20">
                </div>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('movies.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                Cancel
            </a>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                {{ $method === 'PUT' ? 'Update Movie' : 'Create Movie' }}
            </button>
        </div>
    </div>
</form>
