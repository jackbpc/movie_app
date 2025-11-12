<x-app-layout>
    <div class="py-12 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-white drop-shadow-sm">
                    Ratings for <span class="text-purple-400">“{{ $movie->title }}”</span>
                </h1>
                <p class="text-sm text-gray-400 mt-1">Admin Panel – Manage user ratings</p>
            </div>
            <a href="{{ route('movies.index') }}" 
               class="btn-modern bg-gray-800 text-white font-semibold px-4 py-2 rounded-xl hover:bg-gray-700 transition-all">
               ← Back to All Movies
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-600/80 text-white p-3 rounded-xl mb-6 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ratings Table --}}
        @if($ratings->count())
            <div class="overflow-hidden rounded-2xl bg-gray-900/70 backdrop-blur-md shadow-2xl border border-white/10">
                <table class="min-w-full divide-y divide-gray-800 text-white text-sm">
                    <thead class="bg-gray-800/80">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wide text-gray-300">User</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wide text-gray-300">Rating</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wide text-gray-300">Comment</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wide text-gray-300">Date</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wide text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($ratings as $rating)
                            <tr class="hover:bg-gray-800/60 transition-colors">
                                <td class="px-6 py-4">{{ $rating->user->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4">⭐ {{ $rating->rating }}/5</td>
                                <td class="px-6 py-4">{{ $rating->comment ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-400">{{ $rating->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-4 flex flex-wrap gap-2">
                                    <a href="{{ route('admin.ratings.edit', $rating->id) }}" 
                                       class="bg-purple-600/80 hover:bg-purple-500 text-white font-medium px-3 py-1.5 rounded-lg shadow transition-all">
                                       Edit
                                    </a>
                                    <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600/80 hover:bg-red-500 text-white font-medium px-3 py-1.5 rounded-lg shadow transition-all">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-300 mt-6 text-center italic">No ratings found for this movie.</p>
        @endif
    </div>

    {{-- Delete confirmation script --}}
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this rating? This action cannot be undone.');
        }
    </script>
</x-app-layout>
