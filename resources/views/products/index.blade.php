@extends('layouts.app')

@push('meta')
    <meta name="description" content="Discover powerful motivational and mindset-boosting digital products.">
    <meta name="keywords" content="motivation, self-help, productivity, mindset, ebooks, digital downloads">
@endpush

@section('content')
<div class="max-w-7xl mx-auto py-12 px-6">

    <h1 class="text-4xl font-extrabold text-emerald-600 mb-12 text-center tracking-wide">
        Explore Our Collection
    </h1>

    {{-- Filters Panel --}}
    <form method="GET" action="{{ route('products.index') }}" class="mb-10 bg-white/60 backdrop-blur-md rounded-3xl p-6 max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-5 shadow-lg border border-emerald-200">
        <input
            type="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="🔍 Search products..."
            class="text-gray-700 bg-white border border-gray-300 rounded-xl px-5 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 transition"
            aria-label="Search products"
        />

        <select
            name="category"
            class="border border-gray-300 rounded-xl px-5 py-3 bg-white text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 transition"
            aria-label="Filter by category"
        >
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select
            name="sort"
            class="border border-gray-300 rounded-xl px-5 py-3 bg-white text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 transition"
            aria-label="Sort products"
        >
            <option value="">Default Sort</option>
            <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rating</option>
            <option value="purchases" {{ request('sort') === 'purchases' ? 'selected' : '' }}>Most Purchased</option>
            <option value="price_low_high" {{ request('sort') === 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_high_low" {{ request('sort') === 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
        </select>

        <button
            type="submit"
            class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md transition-all px-6 py-3"
            aria-label="Apply filters"
        >
            Apply Filters
        </button>
    </form>

    @if(request()->filled('search') || request()->filled('category') || request()->filled('sort'))
        <div class="mb-8 max-w-5xl mx-auto text-center text-sm text-emerald-700 space-y-1 select-none">
            <p class="font-semibold">Filtered By:</p>
            <div class="flex flex-wrap justify-center gap-4 text-gray-600">
                @if(request()->filled('search'))
                    <span class="bg-emerald-100 rounded-full px-4 py-1">
                        Search: <strong>{{ request('search') }}</strong>
                    </span>
                @endif
                @if(request()->filled('category'))
                    @php $selectedCategory = $categories->firstWhere('id', request('category')); @endphp
                    @if($selectedCategory)
                        <span class="bg-emerald-100 rounded-full px-4 py-1">
                            Category: <strong>{{ $selectedCategory->name }}</strong>
                        </span>
                    @endif
                @endif
                @if(request()->filled('sort'))
                    <span class="bg-emerald-100 rounded-full px-4 py-1">
                        Sort by: 
                        <strong>
                            @switch(request('sort'))
                                @case('rating') Highest Rating @break
                                @case('purchases') Most Purchased @break
                                @case('price_low_high') Price: Low to High @break
                                @case('price_high_low') Price: High to Low @break
                                @default {{ request('sort') }}
                            @endswitch
                        </strong>
                    </span>
                @endif
            </div>
        </div>
    @endif

    @if ($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            @foreach ($products as $product)
                <div
                    class="group relative bg-white rounded-3xl shadow-xl border border-emerald-100 overflow-hidden flex flex-col transition-transform hover:scale-[1.03] hover:shadow-2xl"
                    role="article"
                    aria-label="{{ $product->title }}"
                >
                    <div class="relative w-full h-52 bg-gradient-to-br from-emerald-100 to-lime-100 flex items-center justify-center overflow-hidden">
                        @if($product->cover_image)
                            <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->title }}"
                                class="object-contain h-full w-full transition-transform duration-500 group-hover:scale-105"
                            />
                        @else
                            <div class="text-gray-300 italic text-sm">No Image</div>
                        @endif
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-xl font-semibold text-emerald-900 truncate mb-2" title="{{ $product->title }}">
                            {{ $product->title }}
                        </h3>

                        {{-- Rating --}}
                        @if($product->reviews->count())
                            @php $average = round($product->reviews->avg('rating'), 1); @endphp
                            <div class="flex items-center text-yellow-400 text-sm mb-3" aria-label="Average rating {{ $average }} out of 5 stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($average))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.49 7.91l6.564-.955L10 1l2.946 5.955 6.564.955-4.755 4.635 1.123 6.545z"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-current text-yellow-400 fill-transparent" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1" d="M10 15l-5.878 3.09 1.123-6.545L.49 7.91l6.564-.955L10 1l2.946 5.955 6.564.955-4.755 4.635 1.123 6.545z"/></svg>
                                    @endif
                                @endfor
                                <span class="ml-2 text-gray-500">({{ $product->reviews->count() }})</span>
                            </div>
                        @else
                            <p class="italic text-gray-400 text-sm mb-3">No ratings yet</p>
                        @endif

                        <p class="text-gray-700 text-sm flex-grow line-clamp-4" title="{{ strip_tags($product->description) }}">
                            {!! strip_tags($product->description) !!}
                        </p>

                        <div class="mt-6 flex items-center justify-between">
                            <span class="text-emerald-800 font-bold text-lg select-none">€{{ number_format($product->price, 2) }}</span>

                            <a href="{{ route('products.show', $product->slug) }}"
                                class="inline-block px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition"
                                aria-label="View details for {{ $product->title }}">
                                View
                            </a>
                        </div>
                    </div>

                    <div class="p-4 border-t border-emerald-100 text-sm text-gray-600 select-none">
                        @if($product->order_items_count > 0)
                            {{ $product->order_items_count }} {{ Str::plural('purchase', $product->order_items_count) }}
                        @else
                            <span class="italic text-gray-400">No purchases yet</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center text-gray-400 italic mt-20">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 mb-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L15 12l-5.25-5" />
            </svg>
            No products found matching your criteria.
        </div>
    @endif
</div>
@endsection
