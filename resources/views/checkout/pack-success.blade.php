@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6 text-center">

    {{-- ✅ Success Icon --}}
    <div class="mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    {{-- ✅ Headline --}}
    <h1 class="text-3xl font-bold text-green-700 mb-2">Payment Successful!</h1>
    <p class="text-gray-600 mb-8">
        You’ve successfully purchased the <strong>{{ $pack->title }}</strong> pack.
    </p>

    {{-- ✅ Order summary --}}
    <div class="bg-white shadow rounded-xl p-6 text-left mb-8">
        <h2 class="text-xl font-semibold mb-2 text-green-600">Order Summary</h2>
        <ul class="space-y-1 text-gray-700">
            <li><strong>Order ID:</strong> #{{ $order->id }}</li>
            <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
            <li><strong>Total Paid:</strong> €{{ number_format($order->total_price, 2) }}</li>
            <li><strong>Purchased On:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</li>
        </ul>
    </div>

    {{-- ✅ Included products --}}
    <div class="bg-gray-50 rounded-xl shadow-sm p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Included Products</h2>
        <ul class="divide-y divide-gray-200">
            @foreach($pack->products as $product)
                <li class="py-3 flex justify-between items-center">
                    <span class="font-medium text-gray-700">{{ $product->title }}</span>
                    <a href="{{ URL::signedRoute('download.file', ['order' => $order->id, 'product' => $product->slug]) }}"
                        class="text-emerald-600 hover:text-emerald-700 font-medium">
                        Download →
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- ✅ CTA buttons --}}
    <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="{{ route('purchases.index') }}"
           class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-3 rounded-lg shadow-md transition">
            📦 View All My Purchases
        </a>
        <a href="{{ route('products.index') }}"
           class="inline-block border border-emerald-600 text-emerald-700 hover:bg-emerald-50 font-semibold px-8 py-3 rounded-lg transition">
            ← Continue Shopping
        </a>
    </div>

    {{-- ✅ Tip --}}
    <p class="text-gray-500 text-sm mt-8">
        You can always re-download your files from your
        <a href="{{ route('purchases.index') }}" class="text-emerald-600 hover:underline">Purchases</a> page.
    </p>
</div>
@endsection
