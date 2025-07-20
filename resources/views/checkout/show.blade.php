@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow mt-10">
    <h2 class="text-2xl font-bold mb-4">Checkout: {{ $product->title }}</h2>
    <p class="mb-6">Price: €{{ number_format($product->price, 2) }}</p>

    <form action="{{ route('checkout.process', $product) }}" method="POST">
        @csrf
        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 transition">
            Pay with Card
        </button>
    </form>
</div>
@endsection
