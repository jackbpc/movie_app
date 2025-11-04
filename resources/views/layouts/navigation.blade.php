<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

<nav x-data="{ open: false }" class="glass-nav sticky top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">

        {{-- Logo --}}
        <a href="{{ route('movies.index') }}" class="transform hover:scale-105 transition">
            <x-application-logo class="h-10 w-auto fill-white drop-shadow-lg" />
        </a>

        {{-- Desktop Links --}}
        <div class="hidden md:flex items-center space-x-8">
            <x-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')"
                class="nav-link-modern">{{ __('All Movies') }}</x-nav-link>

            @if(Auth::check() && Auth::user()->role === 'admin')
                <x-nav-link :href="route('movies.create')" :active="request()->routeIs('movies.create')"
                    class="nav-link-modern">{{ __('Create Movie') }}</x-nav-link>
            @endif
        </div>

        {{-- Right Side: Search/Sort only on index --}}
        @if(request()->routeIs('movies.index'))
            <div class="hidden md:flex items-center space-x-3">
                <form method="GET" action="{{ route('movies.index') }}" class="flex items-center space-x-3">
                    {{-- Sort --}}
                    <div class="relative filter-card h-[42px]">
                        <select name="sort" class="custom-select pl-4 pr-10 h-full text-white text-sm w-28">
                            <option value="">Sort by</option>
                            <option value="asc" {{ request('sort')=='asc'?'selected':'' }}>A-Z</option>
                            <option value="desc" {{ request('sort')=='desc'?'selected':'' }}>Z-A</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-purple-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                            <path d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"/>
                        </svg>
                    </div>

                    {{-- Search --}}
                    <div class="relative filter-card h-[42px]">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                               class="h-full pl-10 pr-4 text-white placeholder-gray-400 text-sm w-48"/>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-modern text-white h-[42px] text-sm font-medium"><span>Apply</span></button>
                </form>
            </div>
        @endif

        {{-- User Dropdown / Logout --}}
        @if(Auth::check())
            <div class="hidden md:flex items-center space-x-4">
                <span class="text-gray-200">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="text-sm text-gray-300 hover:text-purple-400 transition">Log Out</button>
                </form>
            </div>
        @endif

        {{-- Mobile Menu Toggle --}}
        <button @click="open=!open" class="md:hidden p-2 text-white hover:bg-white/10 rounded-xl">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{ 'hidden': !open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

    </div>

    {{-- Mobile Menu --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden border-t border-white/10 mobile-menu-bg">
        <div class="px-4 pt-4 pb-6 space-y-3">
            <x-responsive-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')">All Movies</x-responsive-nav-link>

            @if(Auth::check() && Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('movies.create')" :active="request()->routeIs('movies.create')">Create Movie</x-responsive-nav-link>
            @endif

            @if(Auth::check())
                <div class="pt-3 border-t border-white/10 text-gray-200 flex items-center justify-between">
                    <span>{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="text-sm text-gray-300 hover:text-purple-400">Log Out</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    {{-- Genre List: only on index --}}
    @if(request()->routeIs('movies.index'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="genre-list">
                @php
                    $navGenres = ['Action','Sci-Fi','Thriller','Adventure','Drama'];
                    $currentGenre = request('genre');
                @endphp
                <a href="{{ route('movies.index') }}" class="{{ is_null($currentGenre)?'active':'' }}">All Genres</a>
                @foreach($navGenres as $genre)
                    <a href="{{ route('movies.index', ['genre'=>$genre]) }}" class="{{ $currentGenre==$genre?'active':'' }}">{{ $genre }}</a>
                @endforeach
            </div>
        </div>
    @endif
</nav>
