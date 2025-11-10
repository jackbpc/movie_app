<x-app-layout>
<div class="py-12 max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold text-white mb-6">Ratings for "{{ $movie->title }}"</h1>

    @if(session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($ratings->count())
        <table class="min-w-full divide-y divide-gray-700 text-white bg-gray-900 rounded-lg overflow-hidden">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Rating</th>
                    <th class="px-4 py-2 text-left">Comment</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($ratings as $rating)
                    <tr class="hover:bg-gray-800 transition-colors">
                        <td class="px-4 py-2">{{ $rating->user->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-2">⭐ {{ $rating->rating }}/5</td>
                        <td class="px-4 py-2">{{ $rating->comment ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $rating->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.ratings.edit', $rating->id) }}" 
                               class="bg-gray-800 text-white font-semibold px-3 py-1 rounded shadow hover:bg-gray-700 transition-all">
                               Edit
                            </a>
                            <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-800 text-white font-semibold px-3 py-1 rounded shadow hover:bg-gray-700 transition-all">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-300 mt-4">No ratings found for this movie.</p>
    @endif

    <!-- Back Button at the bottom -->
    <div class="mt-6">
        <a href="{{ route('movies.index') }}" 
           class="bg-gray-800 text-white font-semibold py-2 px-4 rounded shadow hover:bg-gray-700 transition-all">
           &larr; Back to All Movies
        </a>
    </div>

</div>

<!-- Delete confirmation script -->
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this rating? This action cannot be undone.');
}
</script>

</x-app-layout>
