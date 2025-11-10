<x-app-layout>
<div class="py-12 bg-gradient-to-b from-gray-900 to-black min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-gray-900/90 rounded-3xl shadow-2xl border border-gray-700 p-8">
            <h1 class="text-3xl font-bold text-white mb-6">Edit Your Review for "{{ $rating->movie->title }}"</h1>

            @if(session('success'))
                <div class="bg-green-600 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('ratings.update', $rating->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-white font-semibold">Rating (1-5)</label>
                    <select name="rating" required
                            class="w-28 bg-gray-800 text-white rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ $rating->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('rating')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-white font-semibold">Comment (optional)</label>
                    <textarea name="comment" rows="3"
                              class="w-full bg-gray-800 text-white rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">{{ $rating->comment }}</textarea>
                    @error('comment')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 mt-4">
                    <button type="submit" class="bg-gray-800 text-white font-semibold py-2 px-5 rounded shadow hover:bg-gray-700 transition-all">
                        Update Review
                    </button>

                    <a href="{{ route('movies.show', $rating->movie->id) }}"
                       class="bg-gray-800 text-white font-semibold py-2 px-5 rounded shadow hover:bg-gray-700 transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>
</x-app-layout>
