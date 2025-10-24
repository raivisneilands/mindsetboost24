@extends('layouts.app')

@section('title', $pack->title . ' | Mindset Boost 24')
@section('meta_description', $pack->description)

@section('content')
<div class="max-w-4xl mx-auto py-16 px-6">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-4xl font-bold text-emerald-600 mb-4">{{ $pack->name }}</h1>
        <p class="text-gray-700 mb-6">{{ $pack->description }}</p>

        <h2 class="text-2xl font-semibold mb-4 text-gray-800">What’s inside:</h2>
        <ul class="space-y-2 mb-6">
            @foreach($pack->products as $product)
                <li class="flex items-center justify-between border-b pb-2">
                    <span class="font-medium text-gray-700">{{ $product->title }}</span>
                    <span class="text-sm text-gray-500">{{ display_price($product->active_price) }}</span>
                </li>
            @endforeach
        </ul>

        <div class="flex items-center justify-between">
            <div>
                <p class="text-lg text-gray-600 mb-2">
                    Regular price: <span class="line-through text-gray-400">{{ display_price($pack->total_price) }}</span>
                </p>
                <p class="text-2xl font-bold text-emerald-600">
                    Now only: {{ display_price($pack->discounted_price) }}
                </p>
            </div>

            <a href="{{ route('checkout.pack', $pack->slug) }}" 
               class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition">
               Get This Pack
            </a>
        </div>
    </div>
</div>
@endsection
