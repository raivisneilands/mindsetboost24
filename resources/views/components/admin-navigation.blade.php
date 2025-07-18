<!-- resources/views/components/admin-navigation.blade.php -->
<nav class="bg-emerald-600 px-6 py-4 flex justify-between items-center shadow-sm">
    <span class="text-green-100 font-bold text-2xl">Admin Panel</span>

    <div class="space-x-6">
        <a href="{{ route('admin.dashboard') }}" class="text-green-200 hover:underline hover:text-green-900 transition">Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="text-green-200 hover:underline hover:text-green-900 transition">Products</a>
        <a href="{{ route('admin.categories.index') }}" class="text-green-200 hover:underline hover:text-green-900 transition">Categories</a>
        <a href="{{ route('admin.orders.index') }}" class="text-green-200 hover:underline hover:text-green-900 transition">Orders</a>
        <a href="{{ route('products.index') }}" class="text-green-200 hover:underline hover:text-green-900 transition">
            Browse Products
        </a>

        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-red-600 hover:underline">Logout</button>
        </form>
    </div>
</nav>
