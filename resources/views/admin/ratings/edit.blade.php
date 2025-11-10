<x-app-layout>
<div class="py-12 max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold text-white mb-6">Edit Rating</h1>

    @if(session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.ratings.update', $rating->id) }}" method="POST" class="space-y-6 bg-gray-900/70 p-6 rounded-xl">
        @csrf
        @method('PUT')

        <!-- User (read-only) -->
        <div>
            <label class="block text-gray-300 font-semibold mb-1">User:</label>
            <input type="text" value="{{ $rating->user->name ?? 'Unknown' }}" disabled
                   class="w-full bg-gray-800 text-white rounded-lg p-2 focus:outline-none">
        </div>

        <!-- Rating -->
        <div>
            <label class="block text-gray-300 font-semibold mb-1">Rating (1-5):</label>
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

        <!-- Comment -->
        <div>
            <label class="block text-gray-300 font-semibold mb-1">Comment:</label>
            <textarea name="comment" rows="3" maxlength="200"
                      class="w-full bg-gray-800 text-white rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('comment', $rating->comment) }}</textarea>
            @error('comment')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit and Back Buttons -->
        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-black text-white font-semibold py-2 px-5 rounded shadow hover:opacity-80 transition-all">
                Update Rating
            </button>

            <a href="{{ route('admin.ratings.index', $rating->movie_id) }}" 
               class="bg-black text-white font-semibold py-2 px-5 rounded shadow hover:opacity-80 transition-all">
               &larr; Back to Ratings
            </a>
        </div>
    </form>

</div>
</x-app-layout>
