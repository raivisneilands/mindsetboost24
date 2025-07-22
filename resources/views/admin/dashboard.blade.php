@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-gray-100 px-4 py-10">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">Admin Dashboard</h1>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @php
                $stats = [
                    ['label' => 'Products', 'value' => $totalProducts, 'color' => 'text-emerald-600'],
                    ['label' => 'Orders', 'value' => $totalOrders, 'color' => 'text-lime-600'],
                    ['label' => 'Users', 'value' => $totalUsers, 'color' => 'text-green-600'],
                    ['label' => 'Downloads', 'value' => $totalDownloads, 'color' => 'text-emerald-500'],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition min-h-[120px] flex flex-col justify-center">
                    <h2 class="text-sm text-gray-500 uppercase mb-1">{{ $stat['label'] }}</h2>
                    <p class="text-3xl font-extrabold {{ $stat['color'] }} break-words">{{ number_format($stat['value']) }}</p>
                </div>
            @endforeach
        </div>

        <!-- Main Panels -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Quick Links -->
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Links</h2>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline">📦 Manage Products</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline">🗂️ Manage Categories</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline">🧾 View Orders</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.download_logs.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline">📥 Download Logs</a>
                    </li>
                </ul>
            </div>

            <!-- Recent Products -->
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Products</h2>
                @if (\App\Models\Product::count())
                    <ul class="divide-y divide-gray-200">
                        @foreach (\App\Models\Product::latest()->take(5)->get() as $product)
                            <li class="py-3 flex justify-between items-center">
                                <span class="font-medium text-gray-700 truncate max-w-[70%]">{{ $product->title }}</span>
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
