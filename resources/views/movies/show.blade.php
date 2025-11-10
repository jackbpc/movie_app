<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

        <!-- Movie Hero Section -->
        <div class="md:flex md:gap-8 items-start">
            
            <!-- Poster -->
            @if($movie->image)
                <img src="{{ asset('images/' . $movie->image) }}" 
                     alt="{{ $movie->title }}" 
                     class="w-full md:w-1/3 h-auto rounded-xl object-cover shadow-lg">
            @endif

            <!-- Movie Info -->
            <div class="mt-6 md:mt-0 flex-1 flex flex-col justify-start space-y-4">
                
                <!-- Title & Genres -->
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">{{ $movie->title }}</h1>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $movie->genre) as $genre)
                            <span class="bg-indigo-100 text-indigo-800 text-sm md:text-base font-semibold px-3 py-1 rounded-full">
                                {{ trim($genre) }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Long Description -->
                <p class="text-white text-sm md:text-base leading-relaxed">
                    {{ $movie->long_description ?? 'No detailed description available.' }}
                </p>

                <!-- Average Rating -->
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-yellow-500 font-bold text-lg md:text-xl">
                        ⭐ {{ $movie->ratings && $movie->ratings->count() ? round($movie->ratings->avg('rating'), 1) : 'N/A' }}/5
                    </span>
                    <span class="text-white text-sm md:text-base font-medium">Average Rating</span>
                </div>

            </div>
        </div>

        <hr class="border-gray-200">

        <!-- Rating & Reviews Section -->
        <div class="md:flex md:gap-8">

            <!-- Rating Form -->
            <div class="flex-1 mb-6 md:mb-0">
                <h3 class="text-white font-bold text-lg md:text-xl mb-4">Submit Your Review</h3>

                @php
                    $userHasRated = auth()->check() 
                        ? $movie->ratings->where('user_id', auth()->id())->count() > 0
                        : false;
                @endphp

                <form id="rating-form" action="{{ route('ratings.store', $movie) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-white text-sm md:text-base font-medium mb-1">Rating</label>
                        <select name="rating" required
                                class="w-24 border-gray-300 text-black border rounded-md p-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">Select</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-white text-sm md:text-base font-medium mb-1">Comment (optional)</label>
                        <textarea name="comment" rows="3" maxlength="200"
                                  class="w-full border-gray-300 border rounded-md p-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                  placeholder="Write your comment...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all">
                        Submit Rating
                    </button>
                </form>
            </div>

            <!-- Recent Reviews -->
            <div class="flex-1">
                <h3 class="text-white font-bold text-lg md:text-xl mb-4">Recent Reviews</h3>

                @if($movie->ratings && $movie->ratings->count())
                    <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
                        @foreach($movie->ratings->take(5) as $rating)
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <span class="text-yellow-500 font-semibold">⭐ {{ $rating->rating }}/5</span>
                                    <span class="text-gray-400 text-xs md:text-sm">{{ $rating->created_at->diffForHumans() }}</span>
                                </div>
                                @if($rating->comment)
                                    <p class="text-gray-700 mt-1">{{ $rating->comment }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- User Actions -->
                    @auth
                        @php
                            $user = auth()->user();
                            $userRating = $movie->ratings->where('user_id', $user->id)->first();
                            $isAdmin = $user->role === 'admin';
                        @endphp

                        <div class="mt-4 flex flex-col md:flex-row gap-3">
                            @if($isAdmin)
                                <a href="{{ route('ratings.index', $movie->id) }}" 
                                   class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition-all">
                                   Manage All Ratings
                                </a>
                            @else
                                <a href="{{ $userRating ? route('ratings.edit', $userRating->id) : '#' }}" 
                                   onclick="return checkUserRating(this);"
                                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow transition-all">
                                   Edit Your Review
                                </a>

                                <form action="{{ $userRating ? route('ratings.destroy', $userRating->id) : '#' }}" method="POST" 
                                      onsubmit="return checkUserRating(this, true);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded shadow transition-all">
                                        Delete Your Review
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endauth
                @else
                    <p class="text-gray-500">No reviews yet. Be the first to rate this movie!</p>
                @endif
            </div>
        </div>
    </div>

<script>
function confirmDeleteUserReview() {
    return confirm('Are you sure you want to delete your review? This action cannot be undone.');
}

function checkUserRating(element, isForm = false) {
    const userHasRated = @json($userHasRated);
    if (!userHasRated) {
        alert('You need to submit a rating before you can edit or delete it.');
        return false;
    }
    if(isForm) return confirmDeleteUserReview();
    return true;
}
</script>
</x-app-layout>
