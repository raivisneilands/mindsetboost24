@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    @if (session('message'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <h1 class="text-3xl font-bold mb-8 text-emerald-600">🛒 My Purchases</h1>

    @if ($orders->isEmpty())
        <p class="text-gray-500 text-center">You haven’t purchased any products yet.</p>
    @else
        <div class="space-y-8">
            @foreach ($orders as $order)
                @if ($order->products->isNotEmpty())
                    <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                            <div>
                                <h2 class="text-lg font-semibold text-emerald-700">Order #{{ $order->id }}</h2>
                                <p class="text-gray-500 text-sm">
                                    {{ $order->created_at->format('F j, Y, g:i a') }}
                                </p>
                            </div>
                            <span class="text-emerald-600 font-bold mt-2 sm:mt-0">
                                €{{ number_format($order->total_price, 2) }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-3">
                            @foreach ($order->products as $product)
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $product->title }}</p>
                                    </div>
                                    <a href="{{ URL::signedRoute('download.file', ['order' => $order->id, 'product' => $product->slug]) }}"
                                       class="mt-2 sm:mt-0 inline-block bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition">
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
