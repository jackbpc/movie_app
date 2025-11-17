<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Create New Movie') }}
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

            {{-- Error messages --}}
            @if ($errors->any())
                <div class="bg-red-600/20 border border-red-400 text-red-100 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-md backdrop-blur-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-6 sm:rounded-3xl ring-1 ring-white/10">
                <h3 class="font-semibold text-lg text-white mb-4">
                    Add a New Movie:
                </h3>

                {{-- Inline Movie Form --}}
                <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label class="block text-white font-medium mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full border-gray-300 border rounded-md p-2  text-black focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>

                    </div>


                    {{-- Description --}}
                    <div>
                        <label class="block text-white font-medium mb-1">Description</label>
                        <textarea name="description" rows="4" required
                                  class="w-full border-gray-300 border rounded-md p-2 text-black focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description') }}</textarea>
                    </div>

                    {{-- Rating --}}
                    <div>
                        <label class="block text-white font-medium mb-1">Rating (0-5)</label>
                        <input type="number" name="rating" value="{{ old('rating') }}" min="0" max="5" step="0.1"
                               class="w-24 border-gray-300 border rounded-md p-2 text-black focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                    </div>

                    {{-- Genre Dropdown --}}
                    <div>
                        <label class="block text-white font-medium mb-1">Genre</label>
                        <select name="genre" required
                                class="w-full border-gray-300 text-black border rounded-md p-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">Select a Genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" {{ old('genre') == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Image Upload --}}
                    <div>
                        <label class="block text-white font-medium mb-1">Movie Poster (optional)</label>
                        <input type="file" name="image"
                               class="w-full border-gray-300 border rounded-md p-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    {{-- Submit Button --}}
                    <div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all">
                            Create Movie
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
