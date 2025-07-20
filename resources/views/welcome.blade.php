@extends('layouts.app')

@section('content')
<div class="bg-emerald-50 min-h-screen">

    {{-- Hero Section --}}
    <section class="bg-emerald-500 text-white py-20">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Discover Powerful Digital Tools</h1>
            <p class="text-lg md:text-xl mb-6">Explore journals, challenges, and guides to boost your motivation and productivity.</p>
            <div class="flex justify-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="bg-lime-500 hover:bg-lime-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                        Get Started
                    </a>
                @endguest
                <a href="{{ route('about') }}" class="bg-white text-emerald-500 hover:text-emerald-600 font-semibold px-6 py-3 rounded-lg border border-white transition">About</a>
                <a href="{{ route('products.index') }}" class="bg-white text-emerald-500 hover:text-emerald-600 font-semibold px-6 py-3 rounded-lg border border-white transition">
                    Browse Products
                </a>
            </div>
        </div>
    </section>

    {{-- Latest Products --}}
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-green-600 mb-6">Latest Products</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($latestProducts as $product)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all border border-lime-100">
                        <div class="relative w-full h-48 bg-lime-50 flex items-center justify-center">
                            @if($product->cover_image)
                                <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->title }}"
                                    class="object-contain h-full w-full p-4" />
                            @else
                                <span class="text-gray-400 text-sm">No Image</span>
                            @endif
                        </div>

                        <div class="p-4 flex flex-col justify-between h-52">
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-green-800 truncate">{{ $product->title }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $product->description }}</p>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-lime-700 font-bold text-base">€{{ number_format($product->price, 2) }}</span>

                                <a href="{{ route('products.show', $product->slug) }}"
                                class="inline-block px-3 py-1 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md transition">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No products available right now.</p>
                @endforelse
            </div>
        </div>
    </section>

</div>
@endsection
