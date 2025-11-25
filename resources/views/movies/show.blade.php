<x-app-layout>
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    <!-- Top Row: Title Left / Rating Right -->
    <div class="flex justify-between items-start mb-8">
      <!-- Movie Title and Details -->
      <div>
        <h1 class="text-4xl font-bold text-white">{{ $movie->title }}</h1>
        <div class="flex gap-4 mt-2 text-gray-300 text-sm">
          <span><strong>Year:</strong> {{ $movie->release_year ?? 'N/A' }}</span>
          <span><strong>Rating:</strong> {{ $movie->age_rating ?? 'N/A' }}</span>
          <span><strong>Runtime:</strong> {{ $movie->runtime ?? 'N/A' }}</span>
        </div>
      </div>

      <!-- Average Rating -->
      <div class="text-right">
        <span class="text-yellow-400 text-2xl font-semibold">
          ⭐ {{ $movie->ratings->count() ? round($movie->ratings->avg('rating'), 1) : 'N/A' }}/5
        </span>
        <div class="text-gray-300 text-sm mt-1">
          {{ $movie->ratings->count() }} rating{{ $movie->ratings->count() === 1 ? '' : 's' }}
        </div>
      </div>
    </div>

    <!-- Poster + Trailer Row -->
    <div class="flex gap-[4px] items-start h-[450px]">
      @php
        $imagePath = $movie->image
            ? asset('images/' . $movie->image)
            : asset('images/placeholder.jpg');
      @endphp

      <!-- Poster -->
      <div class="flex-shrink-0 h-full">
        <img src="{{ $imagePath }}" alt="{{ $movie->title }}" class="h-full w-auto object-cover rounded-lg shadow-lg">
      </div>

      <!-- Trailer -->
      <div class="flex-1 relative h-full">
        @if($movie->trailer_url)
          <iframe class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg"
                  src="{{ $movie->trailer_url }}"
                  title="{{ $movie->title }} Trailer"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
        @else
          <div class="w-full h-full bg-black flex items-center justify-center text-gray-400 rounded-lg shadow-lg">
            No trailer available.
          </div>
        @endif
      </div>
    </div>

    <!-- Long Description -->
    <div class="mt-8 text-gray-200 leading-relaxed text-base">
      <h2 class="text-2xl font-semibold text-white mb-3">Overview</h2>
      <p>{{ $movie->long_description ?? 'No detailed description available.' }}</p>
    </div>

    <!-- Ratings & Reviews Section -->
    <div class="md:flex md:gap-10 space-y-8 md:space-y-0 mt-12">

      <!-- Submit Rating / Review -->
      <div class="md:w-1/2 bg-gray-900 p-6 rounded-lg shadow-md border border-gray-800">
        <h3 class="text-xl font-semibold text-white mb-4">Add Your Review</h3>

        @auth
          @php $userHasRated = $movie->ratings->where('user_id', auth()->id())->isNotEmpty(); @endphp
          @if(!$userHasRated)
            <form action="{{ route('ratings.store', $movie) }}" method="POST" class="space-y-4">
              @csrf
              <div>
                <label class="block text-gray-200 mb-1">Rating</label>
                <select name="rating" required class="w-20 p-2 rounded border border-gray-700 text-black">
                  <option value="">–</option>
                  @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
                @error('rating')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-gray-200 mb-1">Review (optional)</label>
                <textarea name="comment" rows="3" class="w-full p-2 rounded border border-gray-700 text-black" placeholder="Write your review"></textarea>
                @error('comment')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>

              <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">Submit</button>
            </form>
          @else
            <p class="text-gray-400">You have already submitted a review.</p>
          @endif
        @else
          <p class="text-gray-400">Please <a href="{{ route('login') }}" class="underline">login</a> to leave a review.</p>
        @endauth
      </div>

      <!-- Reviews List -->
      <div class="md:w-1/2 bg-gray-900/70 p-6 rounded-lg shadow-md border border-gray-800">
        <h3 class="text-xl font-semibold text-white mb-4">User Reviews</h3>
        <div class="space-y-6 max-h-[32rem] overflow-y-auto pr-2">
          @foreach($movie->ratings->sortByDesc('created_at') as $rating)
            <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
              <div class="flex justify-between items-start mb-2">
                <div class="flex items-center gap-2">
                  <span class="text-yellow-400 font-semibold">⭐ {{ $rating->rating }}/5</span>
                  <span class="text-gray-400 text-sm">by {{ $rating->user->name ?? 'User' }}</span>
                </div>
                <span class="text-gray-500 text-xs">{{ $rating->created_at->diffForHumans() }}</span>
              </div>

              @if($rating->comment)
                <p class="text-gray-200 mb-2">{{ $rating->comment }}</p>
              @endif

              <!-- Controls -->
              @auth
                <div class="flex gap-2 mt-1 text-sm">
                  @if(Auth::id() === $rating->user_id)
                    <!-- Owner can edit/delete -->
                    <a href="{{ route('ratings.edit', $rating) }}" class="text-indigo-400 hover:underline">Edit</a>
                    <form action="{{ route('ratings.destroy', $rating) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Delete your review?')">Delete</button>
                    </form>
                  @elseif(Auth::user()->role === 'admin')
                    <!-- Admin can delete others' ratings -->
                    <form action="{{ route('ratings.destroy', $rating) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Delete this review?')">Delete</button>
                    </form>
                  @endif
                </div>
              @endauth

            </div>
          @endforeach
        </div>
      </div>

    </div>

  </div>
</x-app-layout>
