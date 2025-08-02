@extends('layouts.app')

@push('meta')
    <meta name="description" content="Discover powerful motivational and mindset-boosting digital products.">
    <meta name="keywords" content="motivation, self-help, productivity, mindset, ebooks, digital downloads">
@endpush

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-emerald-500 mb-8">All Products</h1>

    <form method="GET" action="{{ route('products.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Search input --}}
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search products..."
            class="border border-gray-300 rounded-md px-4 py-2 w-full"
        />

        {{-- Category dropdown --}}
        <select name="category" class="border-gray-300 rounded-md px-4 py-2 w-full">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        {{-- Sort dropdown --}}
        <select name="sort" class="border-gray-300 rounded-md px-4 py-2 w-full">
            <option value="">Default Sort</option>
            <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rating</option>
            <option value="purchases" {{ request('sort') === 'purchases' ? 'selected' : '' }}>Most Purchased</option>
            <option value="price_low_high" {{ request('sort') === 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_high_low" {{ request('sort') === 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
        </select>

        {{-- Submit button --}}
        <button type="submit"
            class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-md">
            Apply Filters
        </button>
    </form>

    @if(request()->filled('search') || request()->filled('category') || request()->filled('sort'))
        <div class="mb-6 text-sm text-gray-600 space-y-1">
            <p class="font-medium text-emerald-700">Filtered By:</p>

            <div class="flex">
                @if(request()->filled('search'))
                    <p class="mr-3">Search: <span class="font-semibold">{{ request('search') }}</span></p>
                @endif

                @if(request()->filled('category'))
                    @php
                        $selectedCategory = $categories->firstWhere('id', request('category'));
                    @endphp
                    @if($selectedCategory)
                        <p class="mr-3">Category: <span class="font-semibold">{{ $selectedCategory->name }}</span></p>
                    @endif
                @endif

                @if(request()->filled('sort'))
                    <p>Sort by:
                        <span class="font-semibold">
                            @switch(request('sort'))
                                @case('rating') Highest Rating @break
                                @case('purchases') Most Purchased @break
                                @case('price_low_high') Price: Low to High @break
                                @case('price_high_low') Price: High to Low @break
                                @default {{ request('sort') }}
                            @endswitch
                        </span>
                    </p>
                @endif
            </div>
        </div>
    @endif



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
                            @if($product->reviews->count())
                                @php
                                    $average = number_format($product->reviews->avg('rating'), 1);
                                @endphp
                                <div class="flex items-center text-yellow-500 text-sm mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($average))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-gray-500">({{ $product->reviews->count() }})</span>
                                </div>
                            @else
                                <div class="text-gray-400 text-sm mt-1 italic">No ratings</div>
                            @endif
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
                    @if($product->order_items_count > 0)
                        <div class="text-sm text-gray-600 m-4">
                            {{ $product->order_items_count }} {{ Str::plural('purchase', $product->order_items_count) }}
                        </div>
                    @else
                        <div class="text-sm text-gray-400 m-4 italic">No purchases yet</div>
                    @endif
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
