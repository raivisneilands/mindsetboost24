<!-- resources/views/components/navigation.blade.php -->
<nav class="bg-gradient-to-r from-emerald-500 via-lime-500 to-green-500 px-6 py-4 flex justify-between items-center shadow-sm">
    <a href="{{ route('home') }}" class="text-white font-bold text-2xl">Digital Product Store</a>

    <div class="space-x-4">
        <a href="{{ route('products.index') }}" class="text-white hover:underline hover:text-green-900 transition">Browse Products</a>
        <a href="{{ route('about') }}" 
            class="text-white hover:underline hover:text-green-900 transition">
            About
        </a>

        @guest
            <a href="{{ route('login') }}" class="text-white hover:underline hover:text-green-900 transition">Login</a>
            <a href="{{ route('register') }}" class="text-white hover:underline hover:text-green-900 transition">Register</a>
        @else
            <span class="text-white">Hi, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-red-500 font-bold hover:underline">Logout</button>
            </form>
        @endguest
    </div>
</nav>
