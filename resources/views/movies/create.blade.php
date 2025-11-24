<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Create Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success & Error Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-800 px-6 py-4 rounded-lg mb-6 text-center font-semibold shadow-md">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Container --}}
            <div class="p-6 sm:rounded-3xl ring-1 ring-gray-200 bg-gray-50">
                <h3 class="font-semibold text-lg text-gray-900 mb-4">
                    Add New Movie
                </h3>

                <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label class="block text-gray-900 font-medium mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full border border-gray-300 rounded-md p-2 bg-white text-black placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Title goes here..."
                            required
                        >
                    </div>
                    {{-- Test test  --}}
                    {{-- Short Description --}}
                    <div>
                        <label class="block text-gray-900 font-medium mb-1">Short Description</label>
                        <textarea name="short_description" rows="4"
                            class="w-full border border-gray-300 rounded-md p-2 bg-white text-black placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="A brief summary of the movie goes here..."
                            required>{{ old('short_description') }}</textarea>
                    </div>

                    {{-- Long Description --}}
                    <div>
                        <label class="block text-gray-900 font-medium mb-1">Long Description</label>
                        <textarea name="long_description" rows="6"
                            class="w-full border border-gray-300 rounded-md p-2 bg-white text-black placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="The full detailed plot summary goes here..."
                            required>{{ old('long_description') }}</textarea>
                    </div>

                    {{-- Genres --}}
                    <div>
                        <label class="block text-gray-900 font-medium mb-2">Genres</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($genres as $genre)
                                <label class="inline-flex items-center space-x-2 text-gray-900">
                                    <input type="checkbox" name="genre[]" value="{{ $genre->id }}"
                                        {{ collect(old('genre'))->contains($genre->id) ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                                    <span>{{ $genre->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Movie Poster Upload --}}
                    <div x-data="{
                            preview: null,
                            loadFile(event) {
                                const file = event.target.files[0];
                                if(file) {
                                    this.preview = URL.createObjectURL(file);
                                }
                            }
                        }" class="space-y-3">
                        <label class="block text-gray-900 font-medium mb-1">Movie Poster (optional)</label>

                        <input type="file" name="image"
                               @change="loadFile($event)"
                               class="w-full border border-gray-300 rounded-md p-2 bg-white text-black placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        >

                        {{-- Preview --}}
                        <div class="mt-2" x-show="preview">
                            <p class="text-gray-700 text-sm mb-1">Preview:</p>
                            <img :src="preview" alt="Movie Poster Preview"
                                 class="w-40 h-auto rounded-lg shadow border border-gray-300 object-cover">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-5 rounded-lg shadow transition-all">
                            Create Movie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="//unpkg.com/alpinejs" defer></script>
