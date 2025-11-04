<x-app-layout>

<div class="py-12 bg-gradient-to-b from-gray-900 to-black min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <!-- Movie Card -->
        <div class="bg-gray-900/90 rounded-3xl shadow-2xl border border-gray-700 overflow-hidden space-y-8">

            <!-- Movie Title -->
            <div class="bg-gradient-to-r from-purple-800/80 to-gray-800/70 p-8 text-center">
                <h1 class="text-5xl font-extrabold text-white tracking-tight drop-shadow-lg">
                    {{ $movie->title }}
                </h1>
            </div>

            <!-- Poster and Genres -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-8 px-8">
                @if($movie->image)
                    <img src="{{ asset('images/' . $movie->image) }}" 
                         alt="{{ $movie->title }}" 
                         class="w-full md:w-2/5 h-auto rounded-2xl shadow-2xl transform transition-transform duration-500 hover:scale-105">
                @endif

                <div class="flex-1 space-y-6">
                    <!-- Genres -->
                    <div class="flex flex-wrap gap-3">
                        @foreach(explode(',', $movie->genre) as $genre)
                            <span class="bg-gradient-to-r from-purple-600 to-pink-600 text-white text-sm font-semibold px-4 py-1 rounded-full shadow hover:scale-105 transition-transform">
                                {{ trim($genre) }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Description -->
                    <p class="text-gray-300 text-lg leading-relaxed">
                        {{ $movie->description ?? 'No description available.' }}
                    </p>

                    <!-- Average Rating -->
                    <div class="flex items-center gap-4 mt-4">
                        <span class="text-yellow-400 text-2xl font-bold drop-shadow-lg">
                            ⭐ {{ $movie->ratings && $movie->ratings->count() ? round($movie->ratings->avg('rating'), 1) : 'N/A' }}/5
                        </span>
                        <span class="text-gray-400 mt-1 font-semibold">Average Rating</span>
                    </div>
                </div>
            </div>

            <!-- Rating Form & Recent Ratings -->
            <div class="bg-gray-800/70 p-8 rounded-b-3xl border-t border-gray-700 flex flex-col md:flex-row gap-8">

                <!-- Rating Form -->
                <div class="flex-1 flex flex-col justify-between">
                    <div class="space-y-4">
                        <h3 class="text-white font-bold text-xl">Give Your Rating</h3>

                        @php
                            $userHasRated = auth()->check() 
                                ? $movie->ratings->where('user_id', auth()->id())->count() > 0
                                : false;
                        @endphp

                        <form id="rating-form" action="{{ route('ratings.store', $movie) }}" method="POST" class="flex flex-col gap-3">
                            @csrf

                            <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                                <label class="text-gray-300 text-sm md:text-base">Your Rating (1-5):</label>
                                <select name="rating" required
                                        class="w-28 bg-gray-900 text-white rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="">Select</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('rating')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <textarea name="comment" rows="2" maxlength="200"
                                      class="w-full bg-gray-900 text-white rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                                      placeholder="Optional short comment...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror

                            <!-- Submit button at bottom, floating left -->
                            <div class="mt-4 flex justify-start">
                                <button type="submit" 
                                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-5 rounded-lg transition-all shadow-lg">
                                    Submit Rating
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent Ratings -->
                @if($movie->ratings && $movie->ratings->count())
                    <div class="flex-1 space-y-3 max-h-60 overflow-y-auto">
                        <h4 class="text-white font-semibold text-lg">Recent Ratings</h4>
                        @foreach($movie->ratings->take(3) as $rating)
                            <div class="bg-gray-900/50 p-3 rounded-lg text-gray-200 flex flex-col gap-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-yellow-400 font-semibold">⭐ {{ $rating->rating }}/5</span>
                                    @if($rating->comment)
                                        <span class="italic text-gray-300">- {{ $rating->comment }}</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400">{{ $rating->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

<!-- JS for alert popup -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userHasRated = @json($userHasRated); // Pass PHP variable to JS
    if(userHasRated) {
        const form = document.getElementById('rating-form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('You have already submitted a rating for this movie.');
        });
    }
});
</script>

</x-app-layout>
