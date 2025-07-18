@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-emerald-500 mb-8">All Products</h1>

    @if ($products->count())
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
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
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @else
        <p class="text-gray-500">No products found.</p>
    @endif
</div>
@endsection
