@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-green-600 mb-6">Thank you for your purchase!</h1>

    <p class="mb-4">You have successfully purchased <strong>{{ $product->title }}</strong>.</p>

    <h2 class="text-xl font-semibold mb-2">Order Details:</h2>
    <ul class="mb-6">
        <li><strong>Order ID:</strong> {{ $order->id }}</li>
        <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
        <li><strong>Total Paid:</strong> €{{ number_format($order->total_price, 2) }}</li>
        <li><strong>Purchased On:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</li>
    </ul>

    <a href="{{ URL::signedRoute('download.file', ['order' => $order->id, 'product' => $product->slug]) }}"
        class="bg-emerald-500 text-white p-4 rounded block text-center my-3">
        Download
    </a>

    <a href="{{ route('products.index') }}" class="text-green-700 hover:underline">Continue Shopping</a>
</div>
@endsection
