@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-6 text-emerald-500">My Purchases</h1>

    @if ($orders->count())
        <div class="space-y-4">
            @foreach ($orders as $order)
                @foreach ($order->products as $product)
                    <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold">{{ $product->title }}</h2>
                            <p class="text-gray-600 text-sm">Purchased on {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <a href="{{ URL::signedRoute('download.file', ['order' => $order->id, 'product' => $product->slug]) }}"
                           class="bg-emerald-500 text-white p-4 rounded block text-center my-3">
                            Download
                        </a>
                    </div>
                @endforeach
            @endforeach
        </div>
    @else
        <p class="text-gray-500">You haven't purchased any products yet.</p>
    @endif
</div>
@endsection
