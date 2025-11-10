<div class="bg-white rounded-xl shadow-md overflow-hidden">

    <!-- Movie image -->
    <div class="w-full sm:w-1/3 h-64 flex items-center justify-center border-b sm:border-b-0 sm:border-r border-gray-300 flex-shrink-0">
        <img 
            src="{{ asset('images/' . $movie->image) }}" 
            alt="{{ $movie->title }}" 
            class="max-h-full max-w-full object-contain block"
        >
    </div>

    <!-- Movie text -->
    <div class="p-6 sm:w-2/3 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">{{ $movie->title }}</h2>
            <p class="text-gray-700 mb-4">{{ $movie->description ?? 'No description available.' }}</p>
        </div>
        <div class="text-gray-600">
            <p><span class="font-semibold">Genre:</span> {{ $movie->genre ?? 'Unknown' }}</p>
            <p><span class="font-semibold">Rating:</span> {{ $movie->rating ?? 'N/A' }}</p>
        </div>
    </div>

</div>
