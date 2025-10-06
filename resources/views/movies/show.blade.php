<x-app-layout>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Movie Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">

                <!-- Movie Title -->
                <div class="bg-gray-100 p-6 text-center">
                    <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight">
                        {{ $movie->title }}
                    </h1>
                </div>

                <!-- Movie Poster Image -->
                @if($movie->image)
                <div class="overflow-hidden flex justify-center">
                    <img src="{{ asset('images/' . $movie->image) }}" 
                         alt="{{ $movie->title }}" 
                         class="w-full max-w-md h-auto object-cover transition-transform duration-300 hover:scale-105">
                </div>
                @endif

                <!-- Movie Description -->
                <div class="p-6 text-gray-800 leading-relaxed text-lg">
                    <p>{{ $movie->description ?? 'No description available.' }}</p>
                </div>

                <!-- Movie Metadata Footer -->
                <div class="bg-gray-100 p-6 border-t border-gray-200 flex justify-around text-gray-700 font-semibold">
                    <span><strong>Genre:</strong> {{ $movie->genre ?? 'Unknown' }}</span>
                    <span><strong>Rating:</strong> {{ $movie->rating ?? 'N/A' }}</span>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
