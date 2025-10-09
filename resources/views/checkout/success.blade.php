@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 text-center">

    {{-- ✅ Success Icon --}}
    <div class="mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    {{-- ✅ Headline --}}
    <h1 class="text-3xl font-bold text-green-700 mb-3">Thank you for your purchase!</h1>
    <p class="text-gray-600 mb-8">
        You’ve successfully purchased <strong>{{ $product->title }}</strong>.
        Your download is ready below.
    </p>

    {{-- ✅ Order summary --}}
    <div class="bg-white shadow rounded-lg p-6 text-left mb-8">
        <h2 class="text-xl font-semibold mb-2 text-green-600">Order Summary</h2>
        <ul class="space-y-1 text-gray-700">
            <li><strong>Order ID:</strong> {{ $order->id }}</li>
            <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
            <li><strong>Total Paid:</strong> €{{ number_format($order->total_price, 2) }}</li>
            <li><strong>Purchased On:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</li>
        </ul>
    </div>

    {{-- ✅ Download CTA --}}
    <a href="{{ URL::signedRoute('download.file', ['order' => $order->id, 'product' => $product->slug]) }}"
        class="block bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-lg shadow-md transition mb-4">
        📦 Download Your Product
    </a>

    {{-- ✅ CTA to Purchases page --}}
    <a href="{{ route('purchases.index') }}"
        class="inline-block border border-emerald-600 text-emerald-700 hover:bg-emerald-50 font-semibold px-6 py-3 rounded-lg transition">
        View All My Purchases
    </a>

    {{-- ✅ Optional tip --}}
    <p class="text-gray-500 text-sm mt-6">
        You can always re-download from your <a href="{{ route('purchases.index') }}" class="text-emerald-600 hover:underline">purchases page</a>.
    </p>

    {{-- ✅ Continue Shopping --}}
    <div class="mt-8">
        <a href="{{ route('products.index') }}" class="text-emerald-600 hover:underline">← Continue Shopping</a>
    </div>
</div>
@endsection
