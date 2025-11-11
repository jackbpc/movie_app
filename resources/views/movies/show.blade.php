<x-app-layout>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    {{-- Error / Success Messages --}}
    @if(session('error'))
        <div class="bg-red-600/20 border border-red-400 text-red-100 px-6 py-4 rounded-lg text-center font-semibold shadow-lg backdrop-blur-sm">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-600/20 border border-green-400 text-green-100 px-6 py-4 rounded-lg text-center font-semibold shadow-lg backdrop-blur-sm">
            {{ session('success') }}
        </div>
    @endif

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
                    @foreach($movie->genres as $genre)
                        <span class="bg-indigo-100 text-indigo-800 text-sm md:text-base font-semibold px-3 py-1 rounded-full">
                            {{ $genre->name }}
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
                    ⭐ {{ $movie->ratings->count() ? round($movie->ratings->avg('rating'), 1) : 'N/A' }}/5
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

            @auth
                @php
                    $userHasRated = $movie->ratings->where('user_id', auth()->id())->count() > 0;
                @endphp

                @if(!$userHasRated)
                    <form action="{{ route('ratings.store', $movie) }}" method="POST" class="space-y-4">
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
                @else
                    <p class="text-gray-300">You have already submitted a rating for this movie.</p>
                @endif
            @endauth

            @guest
                <p class="text-gray-300">Please <a href="{{ route('login') }}" class="underline">login</a> to submit a rating.</p>
            @endguest
        </div>

        <!-- Recent Reviews -->
        <div class="flex-1">
            <h3 class="text-white font-bold text-lg md:text-xl mb-4">Recent Reviews</h3>

            <div id="ratings-list" class="space-y-3 max-h-80 overflow-y-auto pr-2">
                @foreach($movie->ratings->sortByDesc('created_at')->take(5) as $rating)
                    <div id="rating-{{ $rating->id }}" class="border border-gray-200 rounded-lg p-3 bg-gray-50 flex justify-between items-start">
                        <div>
                            <div class="flex justify-between items-center">
                                <span class="text-yellow-500 font-semibold">⭐ {{ $rating->rating }}/5</span>
                                <span class="text-gray-400 text-xs md:text-sm">{{ $rating->created_at->diffForHumans() }}</span>
                            </div>
                            @if($rating->comment)
                                <p class="text-gray-700 mt-1">{{ $rating->comment }}</p>
                            @endif
                        </div>

                        @auth
                            @if(auth()->id() === $rating->user_id || auth()->user()->role === 'admin')
                                <div class="flex flex-col gap-1 ml-3">
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('ratings.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs text-center">Manage</a>
                                    @else
                                        <a href="{{ route('ratings.edit', $rating->id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-2 py-1 rounded text-xs text-center">Edit</a>

                                        <!-- Delete Review Form -->
                                        <form action="{{ route('ratings.destroy', $rating) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete your review? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
</x-app-layout>
