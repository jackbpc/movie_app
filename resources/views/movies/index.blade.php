<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies List</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Movies List</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($movies as $movie)
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col sm:flex-row">

        <!-- Movie image -->
        <div class="w-full sm:w-1/3 h-64 flex items-center justify-center bg-gray-200 border-b sm:border-b-0 sm:border-r border-gray-300">
            <img 
                src="{{ asset('images/' . $movie->image) }}" 
                alt="{{ $movie->title }}" 
                class="max-h-full max-w-full object-contain"
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
@endforeach



        </div>
    </div>

</body>
</html>
