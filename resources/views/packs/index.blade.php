@extends('layouts.app')

@section('title', 'Product Packs | Mindset Boost 24')
@section('meta_description', 'Explore our discounted product bundles designed to help you build discipline, focus, and structure — all at a lower price.')

@section('content')
<div class="max-w-6xl mx-auto py-16 px-6">
    <h1 class="text-4xl font-extrabold text-center mb-10 text-emerald-600">
        Product Packs
    </h1>
    <p class="text-center text-gray-600 mb-12">
        Get more. Save more. Each pack combines multiple digital tools to accelerate your growth.
    </p>

    @if($packs->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($packs as $pack)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 p-6 flex flex-col justify-between">
                    
                    <div>
                        {{-- Title & description --}}
                        <h2 class="text-2xl font-bold text-emerald-600 mb-2">{{ $pack->title }}</h2>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $pack->description }}</p>

                        {{-- Product count --}}
                        <p class="text-sm text-gray-500 mb-3">
                            <span class="font-semibold">{{ $pack->products->count() }}</span> included tools
                        </p>

                        {{-- Product previews --}}
                        <ul class="text-sm text-gray-700 mb-4 space-y-1">
                            @foreach($pack->products->take(3) as $product)
                                <li>• {{ $product->title }}</li>
                            @endforeach
                            @if($pack->products->count() > 3)
                                <li class="text-gray-400">+ {{ $pack->products->count() - 3 }} more</li>
                            @endif
                        </ul>

                        {{-- Pricing --}}
                        @php
                            $isFree = $pack->discounted_price == 0;
                            $savings = 0;
                            if (!$isFree && $pack->total_price > 0) {
                                $savings = round((($pack->total_price - $pack->discounted_price) / $pack->total_price) * 100);
                            }
                        @endphp

                        <div class="flex items-center justify-between mb-3">
                            <div>
                                @if($isFree)
                                    <span class="text-emerald-600 text-2xl font-bold">Free</span>
                                @else
                                    <span class="text-gray-400 line-through text-sm">{{ display_price($pack->total_price) }}</span>
                                    <span class="text-emerald-600 text-2xl font-bold ml-2">{{ display_price($pack->discounted_price) }}</span>
                                @endif
                            </div>

                            @if(!$isFree && $savings > 0)
                                <span class="bg-emerald-100 text-emerald-700 text-sm font-semibold py-1 px-2 rounded-full">
                                    -{{ $savings }}%
                                </span>
                            @endif
                        </div>

                    </div>

                    {{-- CTA --}}
                    <a href="{{ route('packs.show', $pack->slug) }}" 
                       class="mt-4 inline-block bg-emerald-600 text-white font-semibold py-3 px-4 rounded-xl text-center hover:bg-emerald-700 transition w-full">
                        View Pack →
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $packs->links('vendor.pagination.tailwind') }}
        </div>
    @else
        <p class="text-center text-gray-500">No packs available yet. Check back soon!</p>
    @endif
</div>
@endsection
