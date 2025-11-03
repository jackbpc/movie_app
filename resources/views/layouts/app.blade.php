<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CineVault') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-100 bg-gradient-to-br from-[#2E114D] via-[#4B1D75] to-[#6E3CA5] min-h-screen">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Header -->
    @isset($header)
        <header class="bg-white/5 backdrop-blur-md border-b border-white/10 shadow-md">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl font-bold tracking-wide text-gray-100 drop-shadow-md">
                    {{ $header }}
                </h1>
            </div>
        </header>
    @endisset

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white/10 backdrop-blur-md shadow-xl rounded-3xl p-8 ring-1 ring-white/10">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm text-purple-200 mt-8 mb-4">
        © {{ date('Y') }} <span class="font-semibold text-white">MyMovieApp</span>. All rights reserved.
    </footer>
</body>
</html>