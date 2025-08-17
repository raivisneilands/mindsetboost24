<nav
    x-data="navbar()"
    x-init="init()"
    :style="visible ? 'opacity: 1; transform: translateY(0);' : 'opacity: 0; transform: translateY(-100%);'"
    class="fixed top-0 left-0 w-full z-50 px-6 py-4 bg-gradient-to-br from-emerald-600 via-emerald-400 to-emerald-500 text-white transition-all duration-500 ease-in-out"
>
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ route('home') }}" class="font-bold text-2xl">Mindset Boost 24</a>

        <button @click="open = !open" class="md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="hidden md:flex space-x-4 items-center">
            <a href="{{ route('products.index') }}" class="hover:underline hover:text-green-900 transition">Browse Products</a>
            <a href="{{ route('about') }}" class="hover:underline hover:text-green-900 transition">About</a>
            <a href="{{ route('ascend.index') }}" class="hover:underline hover:text-green-900 transition">The Ascend</a>

            {{-- Currency Selector --}}
            <form action="{{ route('currency.set') }}" method="POST" class="ml-4">
                @csrf
                <select
                    name="currency"
                    onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg pr-10 py-1 bg-white text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 transition"
                    aria-label="Select currency"
                >
                    @foreach(['EUR', 'USD', 'GBP', 'CAD', 'AUD'] as $cur)
                        <option value="{{ $cur }}" {{ session('currency', 'EUR') === $cur ? 'selected' : '' }}>
                            {{ $cur }}
                        </option>
                    @endforeach
                </select>
            </form>

            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center font-medium hover:text-green-900 focus:outline-none">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                                 alt="Profile"
                                 class="w-8 h-8 rounded-full object-cover mr-2">
                        @else
                            <svg class="w-8 h-8 rounded-full bg-white p-1 mr-2 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4zm0-2a4 4 0 110-8 4 4 0 010 8z"/>
                            </svg>
                        @endif
                        {{ auth()->user()->name }}
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2 text-sm text-black">
                        <a href="{{ route('profile.show', auth()->user()->username) }}" class="block px-4 py-2 hover:bg-emerald-100">My Profile</a>
                        <a href="{{ route('purchases.index') }}" class="block px-4 py-2 hover:bg-emerald-100">My Purchases</a>
                        <a href="{{ route('journal.index') }}" class="block px-4 py-2 hover:bg-emerald-100">My Journal</a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="hover:underline hover:text-green-900 transition">Login</a>
                <a href="{{ route('register') }}" class="hover:underline hover:text-green-900 transition">Register</a>
            @endguest
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="md:hidden mt-4 space-y-2 text-right text-white">
        <div class="block px-4 py-2">
            <form action="{{ route('currency.set') }}" method="POST">
                @csrf
                <select
                    name="currency"
                    onchange="this.form.submit()"
                    class=" border border-gray-300 rounded-lg pr-10 py-2 bg-white text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-400"
                >
                    @foreach(['EUR', 'USD', 'GBP', 'CAD', 'AUD'] as $cur)
                        <option value="{{ $cur }}" {{ session('currency', 'EUR') === $cur ? 'selected' : '' }}>
                            {{ $cur }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <a href="{{ route('products.index') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">Browse Products</a>
        <a href="{{ route('about') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">About</a>
        <a href="{{ route('ascend.index') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">The Ascend</a>
        @auth
            <a href="{{ route('profile.show', auth()->user()->username) }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">My Profile</a>
            <a href="{{ route('profile.edit') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">Edit Profile</a>
            <a href="{{ route('purchases.index') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">My Purchases</a>
            <a href="{{ route('journal.index') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">My Journal</a>
            <form action="{{ route('logout') }}" method="POST" class="px-4">
                @csrf
                <button type="submit" class="text-red-500 font-bold hover:underline">Logout</button>
            </form>
        @endauth
        @guest
            <a href="{{ route('login') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">Login</a>
            <a href="{{ route('register') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">Register</a>
        @endguest
    </div>
</nav>
<script>
    function navbar() {
        return {
            open: false,
            visible: true,
            lastScroll: window.scrollY,

            init() {
                window.addEventListener('scroll', () => {
                    const current = window.scrollY;

                    if (current > this.lastScroll && current > 100) {
                        this.visible = false; // Scrolling down
                    } else if (current < this.lastScroll) {
                        this.visible = true; // Scrolling up
                    }

                    this.lastScroll = current;
                });
            }
        };
    }
</script>
