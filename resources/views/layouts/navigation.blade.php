<style>
select.custom-select, input[type="text"] {
  -webkit-appearance:none; -moz-appearance:none; appearance:none;
  background:transparent; border:none!important; outline:none!important;
  color:#fff; /* Selected text white */
}
select.custom-select option { color:#000; } /* Dropdown options black */
select.custom-select::-ms-expand{display:none;}
select.custom-select:focus, input[type="text"]:focus{box-shadow:none!important;}
.glass-nav{background:rgba(46,17,77,.85);backdrop-filter:blur(20px);
  border-bottom:1px solid rgba(255,255,255,.1);box-shadow:0 8px 32px rgba(0,0,0,.37);}
.nav-link-modern{position:relative;transition:.3s;}
.nav-link-modern::after{content:'';position:absolute;bottom:-4px;left:50%;width:0;height:2px;
  background:linear-gradient(90deg,#a78bfa,#ec4899);transform:translateX(-50%);transition:width .3s;}
.nav-link-modern:hover::after,.nav-link-modern.active::after{width:100%;}
.filter-card{background:rgba(17,24,39,.6);backdrop-filter:blur(10px);border:none!important;transition:.3s;box-shadow:none;}
.filter-card:hover{box-shadow:0 4px 16px rgba(168,85,247,.2);}
.btn-modern{position:relative;background:linear-gradient(135deg,#667eea,#764ba2);border:1px solid rgba(255,255,255,.15);transition:.3s;overflow:hidden;}
.btn-modern::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,#764ba2,#667eea);opacity:0;transition:.3s;}
.btn-modern:hover::before{opacity:1;}
.btn-modern span{position:relative;z-index:1;}
</style>

<nav x-data="{ open:false }" class="glass-nav sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-20 items-center">
    <div class="flex items-center space-x-12">
      <a href="{{ route('dashboard') }}" class="transform hover:scale-105 transition">
        <x-application-logo class="h-10 w-auto fill-white drop-shadow-lg" />
      </a>
      <div class="hidden md:flex space-x-8">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link-modern text-white/90 hover:text-white font-medium text-sm">{{ __('Dashboard') }}</x-nav-link>
        <x-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')" class="nav-link-modern text-white/90 hover:text-white font-medium text-sm">{{ __('All Movies') }}</x-nav-link>
        <x-nav-link :href="route('movies.create')" :active="request()->routeIs('movies.create')" class="nav-link-modern text-white/90 hover:text-white font-medium text-sm">{{ __('Create Movie') }}</x-nav-link>
      </div>
    </div>

    <div class="flex items-center space-x-4">
      @if(request()->routeIs('movies.index') && isset($genres))
      <form method="GET" action="{{ route('movies.index') }}" class="hidden md:flex items-center space-x-3">
        <div class="relative filter-card rounded-xl h-[42px]">
          <select name="sort" class="custom-select pl-4 pr-10 h-full text-white text-sm w-28">
            <option value="">Sort by</option>
            <option value="asc" {{ request('sort')=='asc'?'selected':'' }}>A-Z</option>
            <option value="desc" {{ request('sort')=='desc'?'selected':'' }}>Z-A</option>
          </select>
          <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"/></svg>
        </div>
        <div class="relative filter-card rounded-xl h-[42px]">
          <select name="genre" class="custom-select pl-4 pr-10 h-full text-white text-sm w-36">
            <option value="">All Genres</option>
            @foreach($genres as $genre)
              <option value="{{ $genre }}" {{ request('genre')==$genre?'selected':'' }}>{{ $genre }}</option>
            @endforeach
          </select>
          <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"/></svg>
        </div>
        <div class="relative filter-card rounded-xl overflow-hidden h-[42px]">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="h-full pl-10 pr-4 bg-transparent text-white placeholder-gray-400 text-sm w-48" />
        </div>
        <button type="submit" class="btn-modern text-white px-5 h-[42px] rounded-xl text-sm font-medium shadow-lg"><span>Apply</span></button>
      </form>
      @endif

      @if(Auth::check())
      <div class="hidden md:flex items-center space-x-4">
        <span class="text-gray-200">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">@csrf
          <button type="submit" class="text-sm text-gray-300 hover:text-purple-400 transition">{{ __('Log Out') }}</button>
        </form>
      </div>
      @endif
    </div>

    <button @click="open=!open" class="md:hidden p-2 text-white hover:bg-white/10 rounded-xl">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path :class="{'hidden':open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        <path :class="{'hidden':!open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>

    <div :class="{'block':open,'hidden':!open}" class="hidden md:hidden border-t border-white/10">
      <div class="px-4 pt-4 pb-6 space-y-3 bg-black/20 backdrop-blur-lg">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white/90 hover:text-white hover:bg-white/10 rounded-lg">{{ __('Dashboard') }}</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')" class="text-white/90 hover:text-white hover:bg-white/10 rounded-lg">{{ __('All Movies') }}</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('movies.create')" :active="request()->routeIs('movies.create')" class="text-white/90 hover:text-white hover:bg-white/10 rounded-lg">{{ __('Create Movie') }}</x-responsive-nav-link>

        @if(Auth::check())
        <div class="pt-3 border-t border-white/10 text-gray-200 flex items-center justify-between">
          <span>{{ Auth::user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="text-sm text-gray-300 hover:text-purple-400">{{ __('Log Out') }}</button>
          </form>
        </div>P
        @endif
      </div>
    </div>
  </div>
</nav>
