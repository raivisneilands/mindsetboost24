@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        @if($product->cover_image)
            <img src="{{ asset('storage/' . $product->cover_image) }}"
                 class="w-full h-96 object-cover" alt="{{ $product->title }}">
        @endif

        <div class="p-6">
            <h1 class="text-3xl font-bold text-lime-700 mb-4">{{ $product->title }}</h1>

            <p class="text-gray-700 mb-4">{{ $product->description }}</p>

            <div class="mb-4">
                <span class="text-green-700 font-semibold text-lg">
                    ${{ number_format($product->price, 2) }}
                </span>
            </div>

            @if($product->categories->count())
                <div class="mb-4">
                    <span class="text-sm text-gray-600">Categories:</span>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach ($product->categories as $category)
                            <span class="bg-lime-100 text-lime-700 px-3 py-1 rounded-full text-xs">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($product->images->count())
                <div class="mt-10">
                    <h2 class="text-xl font-semibold text-emerald-600 mb-4">Preview Images</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($product->images as $image)
                            <div class="overflow-hidden rounded-xl shadow-md hover:shadow-lg transition">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                    alt="Product Preview"
                                    class="w-full h-48 object-cover" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('checkout.process', $product) }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" 
                    class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Buy Now
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
