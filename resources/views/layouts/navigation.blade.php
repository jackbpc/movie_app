<nav x-data="{ open: false }" class="bg-gradient-to-r from-[#2E114D] via-[#4B1D75] to-[#6E3CA5] border-b border-white/10 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left: Logo + Main Links -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-white" />
                    </a>
                </div>

                <!-- Main Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-purple-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')" class="text-white hover:text-purple-200">
                        {{ __('All Movies') }}
                    </x-nav-link>
                    <x-nav-link :href="route('movies.create')" :active="request()->routeIs('movies.create')" class="text-white hover:text-purple-200">
                        {{ __('Create Movie') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right: Filters + User Dropdown -->
            <div class="flex items-center space-x-6">
                <!-- Movie Filters -->
                @if(request()->routeIs('movies.index') && isset($genres))
                <form method="GET" action="{{ route('movies.index') }}" class="flex items-center space-x-2">

                    <!-- Search Input -->
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                        class="px-2 py-1 rounded border border-gray-700 bg-gray-900 text-white placeholder-gray-400 focus:outline-none focus:ring focus:ring-purple-500 text-sm" />

                    <!-- Sort Dropdown -->
                    <select name="sort" class="px-2 py-1 rounded border border-gray-700 bg-gray-900 text-white focus:outline-none focus:ring focus:ring-purple-500 text-sm">
                        <option value="">Sort</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>

                    <!-- Genre Dropdown -->
                    <select name="genre" class="px-2 py-1 rounded border border-gray-700 bg-gray-900 text-white focus:outline-none focus:ring focus:ring-purple-500 text-sm">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                        @endforeach
                    </select>

                    <!-- Apply Button -->
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm transition">
                        Apply
                    </button>
                </form>
                @endif

                <!-- User Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-transparent hover:bg-white/10 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-white hover:text-purple-200">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white hover:text-purple-200">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <div class="sm:hidden -mr-2 flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-purple-200 hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Filters included) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-purple-200">{{ __('Dashboard') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')" class="text-white hover:text-purple-200">{{ __('All Movies') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('movies.create')" :active="request()->routeIs('movies.create')" class="text-white hover:text-purple-200">{{ __('Create Movie') }}</x-responsive-nav-link>

            <!-- Mobile Filters -->
            @if(request()->routeIs('movies.index') && isset($genres))
            <form method="GET" action="{{ route('movies.index') }}" class="px-4 py-2 space-y-2">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                    class="w-full px-2 py-1 rounded border border-gray-700 bg-gray-900 text-white placeholder-gray-400 focus:outline-none focus:ring focus:ring-purple-500 text-sm" />

                <!-- Sort Dropdown for Mobile -->
                <select name="sort" class="w-full px-2 py-1 rounded border border-gray-700 bg-gray-900 text-white focus:outline-none focus:ring focus:ring-purple-500 text-sm">
                    <option value="">Sort</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
                </select>

                <select name="genre" class="w-full px-2 py-1 rounded border border-gray-700 bg-gray-900 text-white focus:outline-none focus:ring focus:ring-purple-500 text-sm">
                    <option value="">All Genres</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                    @endforeach
                </select>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm transition">Apply</button>
            </form>
            @endif
        </div>
    </div>
</nav>
