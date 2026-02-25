@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-emerald-600 py-12 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-10">
            <h1 class="text-4xl font-bold text-white">Admin Dashboard</h1>
            <p class="text-emerald-100 mt-2">Overview & management panel</p>
        </div>

        {{-- Stats Overview --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
            @php
                $stats = [
                    ['label' => 'Products', 'value' => $totalProducts],
                    ['label' => 'Orders', 'value' => $totalOrders],
                    ['label' => 'Users', 'value' => $totalUsers],
                    ['label' => 'Downloads', 'value' => $totalDownloads],
                    ['label' => 'Product Packs', 'value' => $totalPacks],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide">
                        {{ $stat['label'] }}
                    </h2>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ number_format($stat['value']) }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- Main Panels --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Quick Links --}}
            <div class="bg-white rounded-2xl shadow-md p-6 lg:col-span-1">
                <h2 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">
                    Quick Links
                </h2>

                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('admin.products.index') }}"
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition">
                            <span class="text-gray-700 font-medium">Manage Products</span>
                            <span class="text-emerald-600">→</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.categories.index') }}"
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition">
                            <span class="text-gray-700 font-medium">Manage Categories</span>
                            <span class="text-emerald-600">→</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.orders.index') }}"
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition">
                            <span class="text-gray-700 font-medium">View Orders</span>
                            <span class="text-emerald-600">→</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.download_logs.index') }}"
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition">
                            <span class="text-gray-700 font-medium">Download Logs</span>
                            <span class="text-emerald-600">→</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.packs.index') }}"
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition">
                            <span class="text-gray-700 font-medium">Manage Product Packs</span>
                            <span class="text-emerald-600">→</span>
                        </a>
                    </li>

                    {{-- New User Management Link --}}
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition">
                            <span class="text-gray-700 font-medium">User Management</span>
                            <span class="text-emerald-600">→</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Recent Products --}}
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">
                    Recent Products
                </h2>

                @if ($latestProducts->count())
                    <ul class="divide-y divide-gray-100">
                        @foreach ($latestProducts as $product)
                            <li class="py-4 flex justify-between items-center">
                                <span class="font-medium text-gray-800 truncate max-w-[70%]">
                                    {{ $product->title }}
                                </span>

                                <span class="text-sm font-semibold text-emerald-600">
                                    @if($product->price > 0)
                                        €{{ number_format($product->price, 2) }}
                                    @else
                                        Free
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No products found yet.</p>
                @endif
            </div>

            {{-- Recent Packs --}}
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">
                    Recent Packs
                </h2>

                @if ($latestPacks->count())
                    <ul class="divide-y divide-gray-100">
                        @foreach ($latestPacks as $pack)
                            <li class="py-4 flex justify-between items-center">
                                <span class="font-medium text-gray-800 truncate max-w-[70%]">
                                    {{ $pack->title }}
                                </span>

                                <span class="text-sm font-semibold text-emerald-600">
                                    @if($pack->discounted_price > 0)
                                        €{{ number_format($pack->discounted_price, 2) }}
                                    @else
                                        Free
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No packs found yet.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection