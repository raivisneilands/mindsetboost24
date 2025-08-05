<!-- resources/views/components/navigation.blade.php -->
<nav x-data="{ open: false }" class="bg-gradient-to-br from-emerald-600 via-emerald-400 to-emerald-500 px-6 py-4 shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-white font-bold text-2xl">Mindset Boost 24</a>

        <!-- Hamburger (Mobile) -->
        <button @click="open = !open" class="text-white md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Desktop Links -->
        <div class="hidden md:flex space-x-4 items-center">
            <a href="{{ route('products.index') }}" class="text-white hover:underline hover:text-green-900 transition">Browse Products</a>
            <a href="{{ route('about') }}" class="text-white hover:underline hover:text-green-900 transition">About</a>

            @auth
                <!-- Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center text-white font-medium hover:text-green-900 focus:outline-none">
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
                        class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2 text-sm">
                        <a href="{{ route('profile.show', auth()->user()->username) }}" class="block px-4 py-2 text-gray-700 hover:bg-emerald-100">My Profile</a>
                        <a href="{{ route('purchases.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-emerald-100">My Purchases</a>
                        <a href="{{ route('journal.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-emerald-100">My Journal</a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="text-white hover:underline hover:text-green-900 transition">Login</a>
                <a href="{{ route('register') }}" class="text-white hover:underline hover:text-green-900 transition">Register</a>
            @endguest
        </div>


    </div>

    <!-- Mobile Dropdown -->
    <div x-show="open" x-transition class="md:hidden mt-4 space-y-2 text-right">
        <a href="{{ route('products.index') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">Browse Products</a>
        <a href="{{ route('about') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">About</a>

        @auth
            <a href="{{ route('profile.show', auth()->user()->username) }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">My Profile</a>
            <a href="{{ route('profile.edit') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">Edit Profile</a>
            <a href="{{ route('purchases.index') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">My Purchases</a>
            <a href="{{ route('journal.index') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">My Journal</a>
            <form action="{{ route('logout') }}" method="POST" class="px-4">
                @csrf
                <button type="submit" class="text-red-500 font-bold hover:underline">Logout</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">Login</a>
            <a href="{{ route('register') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">Register</a>
        @endguest
    </div>

</nav>
