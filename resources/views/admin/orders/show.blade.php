@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Order #{{ $order->id }} Details</h1>

    <div class="bg-white shadow-lg rounded-2xl p-6 space-y-6">

        {{-- Customer Info --}}
        <div class="p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Customer Information</h2>
            <p><span class="font-medium">Name:</span> {{ $order->user->name ?? 'Guest' }}</p>
            <p><span class="font-medium">Email:</span> {{ $order->user->email ?? 'N/A' }}</p>
        </div>

        {{-- Order Info --}}
        <div class="p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Order Information</h2>
            <p><span class="font-medium">Order ID:</span> {{ $order->id }}</p>
            <p>
                <span class="font-medium">Status:</span>
                @php
                    $statusColors = [
                        'completed' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'cancelled' => 'bg-red-100 text-red-700',
                    ];
                @endphp
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            <p><span class="font-medium">Placed On:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
            <p><span class="font-medium">Total Amount:</span> <span class="text-green-600 font-bold">€{{ number_format($order->total_price, 2) }}</span></p>
        </div>

        {{-- Products --}}
        <div class="p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Products</h2>
            <div class="divide-y divide-gray-200">
                @foreach ($order->orderItems as $item)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $item->product->title ?? 'Product Deleted' }}</p>
                            <p class="text-gray-600 text-sm">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-green-600">€{{ number_format($item->price, 2) }}</p>
                            <p class="text-gray-600 text-sm">Subtotal: €{{ number_format($item->quantity * $item->price, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Back Button --}}
        <div>
            <a href="{{ route('admin.orders.index') }}" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg shadow">
                ← Back to Orders
            </a>
        </div>

    </div>
</div>
@endsection