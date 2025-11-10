<x-app-layout>

<div class="py-12 flex justify-center items-start min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <!-- Success / Error Alerts -->
        @if(session('success'))
            <div id="alert-success" class="bg-green-600 text-white p-3 rounded mb-6 transition-all duration-700 transform translate-y-[-20px] opacity-0">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div id="alert-error" class="bg-red-600 text-white p-3 rounded mb-6 transition-all duration-700 transform translate-y-[-20px] opacity-0">
                {{ session('error') }}
            </div>
        @endif

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
                    <div class="flex-1 space-y-3">
                        <h4 class="text-white font-semibold text-lg mb-2">Recent Ratings</h4>

                        <div class="max-h-60 overflow-y-auto space-y-3">
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

                        <!-- User/Admin Action Buttons – OUTSIDE scrollable area -->
                        @auth
                            @php
                                $user = auth()->user();
                                $userRating = $movie->ratings->where('user_id', $user->id)->first();
                                $isAdmin = isset($user->is_admin) && $user->is_admin;
                            @endphp

                            <div class="mt-4 flex gap-2">
                                @if($isAdmin)
                                    <a href="{{ route('ratings.index', $movie->id) }}" 
                                       class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all">
                                       Manage All Ratings
                                    </a>
                                @else
                                    <a href="{{ $userRating ? route('ratings.edit', $userRating->id) : '#' }}" 
                                       onclick="return checkUserRating(this);"
                                       class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all">
                                       Edit Your Review
                                    </a>

                                    <form action="{{ $userRating ? route('ratings.destroy', $userRating->id) : '#' }}" method="POST" 
                                          onsubmit="return checkUserRating(this, true);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all">
                                            Delete Your Review
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endauth
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

<!-- JS Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userHasRated = @json($userHasRated);

    // Block rating form if already rated
    if(userHasRated) {
        const form = document.getElementById('rating-form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('You have already submitted a rating for this movie.');
        });
    }

    // Animate success/error alerts
    function animateAlert(alertId) {
        const alert = document.getElementById(alertId);
        if(alert) {
            // Slide in
            alert.style.opacity = 1;
            alert.style.transform = 'translateY(0)';
            // Slide out after 5s
            setTimeout(() => {
                alert.style.opacity = 0;
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 700);
            }, 5000);
        }
    }

    animateAlert('alert-success');
    animateAlert('alert-error');
});

// Confirm deletion
function confirmDeleteUserReview() {
    return confirm('Are you sure you want to delete your review? This action cannot be undone.');
}

// Check if user has a rating before editing/deleting
function checkUserRating(element, isForm = false) {
    const userHasRated = @json($userHasRated);
    if (!userHasRated) {
        alert('You need to submit a rating before you can edit or delete it.');
        return false;
    }

    if(isForm) {
        return confirmDeleteUserReview();
    }

    return true;
}
</script>

</x-app-layout>
