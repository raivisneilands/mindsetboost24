<nav
    x-data="{
        open: false,
        show: true,
        lastScroll: 0,
        isHome: {{ request()->is('/') ? 'true' : 'false' }},
        scrolled: false
    }"
    x-init="
        window.addEventListener('scroll', () => {
            let currentScroll = window.pageYOffset;

            // Hide / show (ALL pages)
            show = currentScroll < lastScroll || currentScroll < 50;

            // Solid after scroll (HOMEPAGE ONLY)
            if (isHome) {
                scrolled = currentScroll > 600;
            }

            lastScroll = currentScroll;
        });
    "
    :class="[
        show ? 'translate-y-0' : '-translate-y-full',

        isHome
            ? (scrolled
                ? 'bg-gradient-to-br from-emerald-900 via-emerald-700 to-emerald-500 shadow-xl'
                : 'bg-gradient-to-br from-emerald-900/10 via-emerald-700/10 to-emerald-500/10 backdrop-blur-xl border-b border-white/10')
            : 'bg-gradient-to-br from-emerald-900 via-emerald-700 to-emerald-500 shadow-xl'
    ]"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500 text-white"
>
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

    {{-- Logo --}}
    <a href="{{ route('home') }}"
    class="group select-none flex items-center gap-1 md:gap-2
            transition-all duration-200 hover:scale-105 hover:-translate-y-0.5">

        {{-- Mindset --}}
        <span class="text-2xl font-semibold tracking-tight uppercase
                    bg-gradient-to-r from-white via-white/90 to-white
                    bg-[length:200%_200%] bg-left
                    bg-clip-text text-transparent
                    transition-all duration-700
                    group-hover:bg-right
                    group-hover:tracking-wide">
            Mindset
        </span>

        {{-- Boost --}}
        <span class="text-2xl font-light tracking-wide uppercase ml-1
                    bg-gradient-to-r from-white/90 via-white/70 to-white/90
                    bg-[length:200%_200%] bg-left
                    bg-clip-text text-transparent
                    transition-all duration-700
                    group-hover:bg-right">
            Boost
        </span>

        {{-- 24 --}}
        <span class="text-2xl font-bold ml-2
                    bg-gradient-to-r from-emerald-300 via-emerald-400 to-emerald-500
                    bg-[length:200%_200%] bg-left
                    bg-clip-text text-transparent
                    transition-all duration-700
                    group-hover:bg-right
                    group-hover:drop-shadow-[0_0_12px_rgba(16,185,129,0.7)]">
            24
        </span>

    </a>

        {{-- Desktop Menu --}}
        <div class="hidden md:flex items-center space-x-8 text-sm font-medium">

            @foreach ([
                ['route' => 'packs.index', 'label' => 'Packs'],
                ['route' => 'products.index', 'label' => 'Products'],
                ['route' => 'ascend.index', 'label' => 'The Ascend'],
                ['route' => 'about', 'label' => 'About']
            ] as $link)
                <a href="{{ route($link['route']) }}" 
                   class="relative group transition-colors duration-300 hover:text-emerald-300">
                    {{ $link['label'] }}
                    <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-emerald-300 transition-all duration-300 group-hover:w-full rounded"></span>
                </a>
            @endforeach

        <!-- Premium currency dropdown -->
        <div x-data="{ open: false }" class="relative ml-4 text-sm font-medium">
            <button @click="open = !open"
                    class="flex items-center gap-2 px-3 py-1 bg-transparent text-white rounded-md shadow-sm hover:bg-white/10 transition">
                {{ session('currency', 'EUR') }}
                <svg class="w-4 h-4 mt-[1px] transition-transform duration-200" 
                    :class="open ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-36 bg-white/90 rounded-md shadow-xl py-1 border border-white/30 z-50">
                @foreach(['EUR', 'USD', 'GBP', 'CAD', 'AUD'] as $cur)
                    <form action="{{ route('currency.set') }}" method="POST">
                        @csrf
                        <input type="hidden" name="currency" value="{{ $cur }}">
                        <button type="submit" 
                                class="w-full text-left px-4 py-2 hover:bg-emerald-100/20 transition flex justify-between items-center text-gray-900 font-medium">
                            {{ $cur }}
                            @if(session('currency', 'EUR') === $cur)
                                <span class="text-emerald-500 font-bold">✓</span>
                            @endif
                        </button>
                    </form>
                @endforeach
            </div>
        </div>

            {{-- Auth --}}
            @auth
                <div x-data="{ dropdown: false }" class="relative ml-4">
                    <button @click="dropdown = !dropdown"
                            class="flex items-center gap-2 rounded-md px-2 py-1 hover:bg-white/10 transition text-white">
                        {{-- Avatar --}}
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image" class="w-8 h-8 rounded-full object-cover border border-white/20">
                        @else
                            <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center font-bold text-white text-sm">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif

                        <span class="font-semibold truncate max-w-[100px]">{{ auth()->user()->name }}</span>

                        <svg class="w-4 h-4 mt-[1px] transition-transform duration-200" 
                             :class="dropdown ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="dropdown" @click.away="dropdown = false" x-transition
                         class="absolute right-0 mt-3 w-56 bg-white text-gray-800 shadow-xl rounded-lg py-2 border border-gray-100">
                        <a href="{{ route('profile.show', auth()->user()->username) }}" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
                        <a href="{{ route('purchases.index') }}" class="block px-4 py-2 hover:bg-gray-100">My Purchases</a>
                        <a href="{{ route('journal.index') }}" class="block px-4 py-2 hover:bg-gray-100">My Journal</a>
                        <a href="{{ route('badges.index') }}" class="block px-4 py-2 hover:bg-gray-100">My Badges</a>
                        @if(auth()->user()->is_admin ?? false)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 font-semibold text-emerald-700 hover:bg-gray-100">Admin Dashboard</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-4 ml-4">
                    <a href="{{ route('login') }}" class="text-white hover:text-emerald-300 transition">Login</a>
                    <a href="{{ route('register') }}" 
                    class="px-4 py-2 bg-white/20 text-white/90 rounded-md text-sm font-semibold hover:bg-white/30 transition shadow-sm">
                        Join Free
                    </a>                
                </div>
            @endauth
        </div>

        {{-- Mobile Menu Button --}}
        <button @click="open = !open" class="md:hidden text-white hover:text-emerald-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Mobile Dropdown --}}
    <div x-show="open" x-transition class="md:hidden bg-emerald-700 px-6 py-4 space-y-4 text-white text-sm rounded-b-lg shadow-inner">
        <a href="{{ route('packs.index') }}" class="block hover:text-emerald-300 transition">Packs</a>
        <a href="{{ route('products.index') }}" class="block hover:text-emerald-300 transition">Products</a>
        <a href="{{ route('ascend.index') }}" class="block hover:text-emerald-300 transition">The Ascend</a>
        <a href="{{ route('about') }}" class="block hover:text-emerald-300 transition">About</a>

        @auth
            <a href="{{ route('profile.show', auth()->user()->username) }}" class="block hover:text-emerald-300">My Profile</a>
            <a href="{{ route('purchases.index') }}" class="block hover:text-emerald-300">My Purchases</a>
            <a href="{{ route('journal.index') }}" class="block hover:text-emerald-300">My Journal</a>
            <a href="{{ route('badges.index') }}" class="block hover:text-emerald-300">My Badges</a>
            @if(auth()->user()->is_admin ?? false)
                <a href="{{ route('admin.dashboard') }}" class="block hover:text-emerald-300">Admin Dashboard</a>
            @endif
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-400 font-medium w-full text-left">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block hover:text-emerald-300">Login</a>
            <a href="{{ route('register') }}" class="block font-semibold hover:text-emerald-300">Join Free</a>
        @endauth
    </div>
</nav>