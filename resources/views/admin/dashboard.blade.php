@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-gray-100 px-4 py-10">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Products -->
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h2 class="text-gray-500 text-sm uppercase mb-1">Total Products</h2>
                <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Product::count() }}</p>
            </div>

            <!-- Total Categories -->
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h2 class="text-gray-500 text-sm uppercase mb-1">Total Categories</h2>
                <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Category::count() }}</p>
            </div>

            <!-- Placeholder -->
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h2 class="text-gray-500 text-sm uppercase mb-1">Coming Soon</h2>
                <p class="text-gray-500">More insights on orders, users, downloads...</p>
            </div>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Quick Links -->
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Links</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline hover:text-blue-800">📦 Manage Products</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline hover:text-blue-800">🗂️ Manage Categories</a>
                    </li>
                </ul>
            </div>

            <!-- Recent Products -->
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Products</h2>
                @if (\App\Models\Product::count())
                    <ul class="divide-y divide-gray-200">
                        @foreach (\App\Models\Product::latest()->take(5)->get() as $product)
                            <li class="py-2 flex justify-between">
                                <span class="font-medium text-gray-700">{{ $product->name }}</span>
                                <span class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No products found yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
