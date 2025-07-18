@extends('layouts.app')


@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-lime-500 mb-6">Order #{{ $order->id }} Details</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Customer Information</h2>
            <p><span class="font-medium">Name:</span> {{ $order->user->name ?? 'Guest' }}</p>
            <p><span class="font-medium">Email:</span> {{ $order->user->email ?? 'N/A' }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Order Info</h2>
            <p><span class="font-medium">Order ID:</span> {{ $order->id }}</p>
            <p><span class="font-medium">Status:</span> 
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            <p><span class="font-medium">Placed On:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
            <p><span class="font-medium">Total Amount:</span> <span class="text-green-600 font-bold">€{{ number_format($order->total_price, 2) }}</span></p>
        </div>

        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Products</h2>
            <div class="border rounded">
                @foreach ($order->orderItems as $item)
                    <div class="flex items-center justify-between px-4 py-3 border-b last:border-b-0">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item->product->title ?? 'Product Deleted' }}</p>
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

        <div class="mt-6">
            <a href="{{ route('admin.orders.index') }}" class="inline-block bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded shadow">
                Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection
