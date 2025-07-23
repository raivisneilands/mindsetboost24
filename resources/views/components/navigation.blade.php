<!-- resources/views/components/navigation.blade.php -->
<nav x-data="{ open: false }" class="bg-gradient-to-r from-emerald-500 via-lime-500 to-green-500 px-6 py-4 shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-white font-bold text-2xl">Digital Product Store</a>

        <!-- Hamburger (Mobile) -->
        <button @click="open = !open" class="text-white md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Links (Desktop) -->
        <div class="hidden md:flex space-x-4 items-center">
            @auth
                <span class="block text-white px-4">Hi, {{ auth()->user()->name }}</span>       
            @endauth
            <a href="{{ route('products.index') }}" class="text-white hover:underline hover:text-green-900 transition">Browse Products</a>
            <a href="{{ route('about') }}" class="text-white hover:underline hover:text-green-900 transition">About</a>
            @auth
                <a href="{{ route('purchases.index') }}" class="text-white hover:underline">My Purchases</a>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="text-white hover:underline hover:text-green-900 transition">Login</a>
                <a href="{{ route('register') }}" class="text-white hover:underline hover:text-green-900 transition">Register</a>
            @else
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 font-bold hover:underline">Logout</button>
                </form>
            @endguest
        </div>
    </div>

    <!-- Links (Mobile Dropdown) -->
    <div x-show="open" x-transition class="md:hidden mt-4 space-y-2 text-right">
        @auth
            <span class="block text-white px-4">Hi, {{ auth()->user()->name }}</span>       
        @endauth
        <a href="{{ route('products.index') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">Browse Products</a>
        <a href="{{ route('about') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">About</a>

        @guest
            <a href="{{ route('login') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">Login</a>
            <a href="{{ route('register') }}" class="block text-white hover:bg-emerald-600 px-4 py-2 rounded">Register</a>
        @else
            <form action="{{ route('logout') }}" method="POST" class="px-4">
                @csrf
                <button type="submit" class="text-red-500 font-bold hover:underline">Logout</button>
            </form>
        @endguest
    </div>
</nav>
