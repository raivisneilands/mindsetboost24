<nav
    x-data="{ open: false, visible: true, lastScroll: 0 }"
    x-init="
        window.addEventListener('scroll', () => {
            const current = window.scrollY;
            if (current > lastScroll && current > 80) visible = false;
            else visible = true;
            lastScroll = current;
        });
    "
    :class="visible ? 'translate-y-0 opacity-100' : '-translate-y-full opacity-0'"
    class="fixed top-0 left-0 w-full z-50 backdrop-blur-xl bg-emerald-600/60 border-b border-emerald-100/40 transition-all duration-500 ease-in-out shadow-sm"
>
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <img src="{{ asset('favicon.png') }}" alt="Mindset Boost 24" class="w-10 h-10 transition-transform duration-300 group-hover:rotate-12">
            <span class="text-white text-2xl font-extrabold tracking-tight group-hover:text-emerald-200 transition-colors">
                Mindset Boost 24
            </span>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-white">
            @foreach ([
                ['route' => 'packs.index', 'label' => 'Packs'],
                ['route' => 'products.index', 'label' => 'Products'],
                ['route' => 'ascend.index', 'label' => 'The Ascend'],
                ['route' => 'about', 'label' => 'About']
            ] as $link)
                <a href="{{ route($link['route']) }}"
                   class="relative transition-all duration-200 hover:text-white/90 after:absolute after:bottom-0 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-white/80 after:transition-all after:duration-300">
                   {{ $link['label'] }}
                </a>
            @endforeach

            {{-- Currency Selector --}}
            <form action="{{ route('currency.set') }}" method="POST" class="ml-2">
                @csrf
                <select
                    name="currency"
                    onchange="this.form.submit()"
                    class="pr-7 text-emerald-800 text-sm border border-white/30 rounded-md bg-white/70 backdrop-blur-sm py-1 px-2 focus:ring-emerald-400 focus:border-emerald-400 transition font-semibold"
                >
                    @foreach(['EUR', 'USD', 'GBP', 'CAD', 'AUD'] as $cur)
                        <option value="{{ $cur }}" {{ session('currency', 'EUR') === $cur ? 'selected' : '' }}>
                            {{ $cur }}
                        </option>
                    @endforeach
                </select>
            </form>

            {{-- Auth / Guest --}}
            @auth
                <div x-data="{ dropdown: false }" class="relative">
                    <button @click="dropdown = !dropdown"
                        class="flex items-center gap-2 text-white hover:text-emerald-100 transition">
                        @if (auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                                class="w-8 h-8 rounded-full object-cover border border-white/50 shadow-sm">
                        @else
                            <svg class="w-8 h-8 rounded-full bg-white/90 p-1 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4zm0-2a4 4 0 110-8 4 4 0 010 8z"/>
                            </svg>
                        @endif
                        <span class="font-semibold">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 mt-[2px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        x-show="dropdown" @click.away="dropdown = false"
                        x-transition
                        class="absolute right-0 mt-3 w-52 bg-white/95 backdrop-blur-lg shadow-lg rounded-xl py-2 border border-gray-100"
                    >
                        <a href="{{ route('profile.show', auth()->user()->username) }}" class="block px-4 py-2 hover:bg-emerald-50 text-gray-700">My Profile</a>
                        <a href="{{ route('purchases.index') }}" class="block px-4 py-2 hover:bg-emerald-50 text-gray-700">My Purchases</a>
                        <a href="{{ route('journal.index') }}" class="block px-4 py-2 hover:bg-emerald-50 text-gray-700">My Journal</a>
                        @if(auth()->user()->is_admin ?? false)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 font-semibold text-emerald-600 hover:bg-emerald-100">
                                🛠 Admin Dashboard
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-white/90 hover:text-white font-semibold transition">Login</a>
                    <a href="{{ route('register') }}" class="ml-3 px-4 py-2 bg-white/90 text-emerald-700 rounded-full text-sm font-semibold hover:bg-white transition">
                        Join Free
                    </a>
                </div>
            @endauth
        </div>

        {{-- Mobile Menu Button --}}
        <button @click="open = !open" class="md:hidden text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Mobile Dropdown --}}
    <div
        x-show="open"
        x-transition
        class="absolute right-4 top-[70px] md:hidden bg-white/95 backdrop-blur-xl border border-emerald-100 shadow-2xl 
            rounded-2xl text-right space-y-3 py-4 px-6 text-gray-700 font-medium w-[70%] sm:w-[50%]"
    >
        <a href="{{ route('packs.index') }}" class="block hover:text-emerald-600">Packs</a>
        <a href="{{ route('products.index') }}" class="block hover:text-emerald-600">Products</a>
        <a href="{{ route('ascend.index') }}" class="block hover:text-emerald-600">The Ascend</a>
        <a href="{{ route('about') }}" class="block hover:text-emerald-600">About</a>

        <form action="{{ route('currency.set') }}" method="POST">
            @csrf
            <select name="currency" onchange="this.form.submit()"
                class="border border-gray-200 rounded-md bg-white py-1 px-2 focus:ring-emerald-400 focus:border-emerald-400 transition text-sm pr-7">
                @foreach(['EUR', 'USD', 'GBP', 'CAD', 'AUD'] as $cur)
                    <option value="{{ $cur }}" {{ session('currency', 'EUR') === $cur ? 'selected' : '' }}>
                        {{ $cur }}
                    </option>
                @endforeach
            </select>
        </form>

        @auth
            <a href="{{ route('profile.show', auth()->user()->username) }}" class="block hover:text-emerald-600">My Profile</a>
            <a href="{{ route('purchases.index') }}" class="block hover:text-emerald-600">My Purchases</a>
            <a href="{{ route('journal.index') }}" class="block hover:text-emerald-600">My Journal</a>
            @if(auth()->user()->is_admin ?? false)
                <a href="{{ route('admin.dashboard') }}" class="block font-semibold text-emerald-600 hover:text-emerald-700">🛠 Admin Dashboard</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="pt-2">
                @csrf
                <button type="submit" class="text-red-500 font-semibold">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block hover:text-emerald-600">Login</a>
            <a href="{{ route('register') }}" class="block text-emerald-700 font-semibold">Join Free</a>
        @endauth
    </div>
</nav>
