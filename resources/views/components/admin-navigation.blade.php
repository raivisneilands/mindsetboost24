<!-- resources/views/components/admin-navigation.blade.php -->
<nav x-data="{ open: false }" class="bg-gradient-to-br from-emerald-600 via-emerald-400 to-emerald-500 px-6 py-4 shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo / Title -->
        <a href="{{ route('home') }}" class="text-white font-bold text-2xl">Admin Panel</a>

        <!-- Hamburger (Mobile) -->
        <button @click="open = !open" class="text-white md:hidden focus:outline-none" aria-label="Toggle navigation menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Links (Desktop) -->
        <div class="hidden md:flex space-x-6 items-center text-white">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline hover:text-green-900 transition">Dashboard</a>
            <a href="{{ route('products.index') }}" class="hover:underline hover:text-green-900 transition">Browse Products</a>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-red-500 font-bold hover:underline">Logout</button>
            </form>
        </div>
    </div>

    <!-- Links (Mobile Dropdown) -->
    <div x-show="open" x-transition class="md:hidden mt-4 space-y-2 text-right text-white">
        <a href="{{ route('admin.dashboard') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">Dashboard</a>
        <a href="{{ route('products.index') }}" class="block hover:bg-emerald-600 px-4 py-2 rounded">Browse Products</a>

        <form action="{{ route('logout') }}" method="POST" class="px-4">
            @csrf
            <button type="submit" class="text-red-500 font-bold hover:underline py-2 w-full text-right">Logout</button>
        </form>
    </div>
</nav>
