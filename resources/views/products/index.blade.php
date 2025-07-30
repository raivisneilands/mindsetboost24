@extends('layouts.app')

@push('meta')
    <meta name="description" content="Discover powerful motivational and mindset-boosting digital products.">
    <meta name="keywords" content="motivation, self-help, productivity, mindset, ebooks, digital downloads">
@endpush

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-emerald-500 mb-8">All Products</h1>

    <form method="GET" action="{{ route('products.index') }}" class="mb-8 flex flex-col md:flex-row md:items-end gap-4">
        {{-- Category Filter --}}
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Search --}}
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500"
                placeholder="Search by title or description">
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-emerald-500 border border-transparent rounded-md font-semibold text-white hover:bg-emerald-600 transition">
                Filter
            </button>
        </div>

        <div class="flex gap-2">
            <a
                href="{{ route('products.index') }}"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg"
            >
                Clear Filters
            </a>
        </div>
    </form>


    @if ($products->count())
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all border border-lime-100 flex flex-col">
                    <div class="relative w-full h-48 bg-lime-50 flex items-center justify-center">
                        @if($product->cover_image)
                            <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->title }}"
                                class="object-contain h-full w-full p-4" />
                        @else
                            <span class="text-gray-400 text-sm">No Image</span>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <div class="mb-3">
                            <h3 class="text-lg font-semibold text-green-800 truncate">{{ $product->title }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-3">{!!  strip_tags($product->description) !!}</p>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
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
