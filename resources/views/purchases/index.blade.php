@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    @if (session('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif
    <h1 class="text-3xl font-bold mb-6 text-emerald-500">My Purchases</h1>

    @php
        // Collect all products from all orders
        $allProducts = $orders->flatMap(fn($order) => $order->products);
    @endphp

    @if ($allProducts->count())
        <div class="space-y-4">
            @foreach ($allProducts as $product)
                @php
                    // Find the order this product belongs to
                    $order = $orders->first(fn($o) => $o->products->contains($product));
                @endphp
                <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $product->title }}</h2>
                        <p class="text-gray-600 text-sm">Purchased on {{ $order->created_at->format('F j, Y, g:i a') }}</p>
                        @if ($product->price == 0)
                            <span class="text-green-600 font-medium text-sm">Free Gift</span>
                        @endif
                    </div>
                    <a href="{{ URL::signedRoute('download.file', ['order' => $order->id, 'product' => $product->slug]) }}"
                       class="bg-emerald-500 text-white p-4 rounded block text-center my-3">
                        Download
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">You haven't purchased any products yet.</p>
    @endif
</div>
@endsection
