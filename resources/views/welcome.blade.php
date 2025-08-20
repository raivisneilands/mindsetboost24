@extends('layouts.app')

@section('content')
<div class="bg-emerald-50 min-h-screen">

    {{-- 🔥 HERO: Attention-Grabbing Start --}}
    <section class="relative bg-cover bg-center bg-no-repeat text-white py-32 overflow-hidden" style="background-image: url('{{ asset('images/hero-background.jpg') }}');">
        {{-- Pre-signup welcome gift message --}}
        @guest
            <div class="relative z-20 max-w-3xl mx-auto px-4 py-4 mb-8 
                        bg-emerald-600/95 text-white rounded-2xl shadow-xl 
                        border border-emerald-400 text-center text-base sm:text-lg 
                        animate-pulse-slow">
                🎁 <strong>Sign up today</strong> and unlock 
                <span class="font-semibold">multiple free resources</span> instantly after verifying your email!
            </div>
        @endguest

        @if(session('gift'))
            <div class="relative z-20 max-w-3xl mx-auto px-4 py-4 mb-8 
                        bg-emerald-500/95 text-white rounded-2xl shadow-xl 
                        border border-emerald-300 text-center text-base sm:text-lg">
                {!! session('gift') !!}
            </div>
        @endif

        {{-- Gradient overlays --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-700/80 via-emerald-800/70 to-emerald-900/70"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent opacity-40 animate-pulse pointer-events-none"></div>

        <div class="container mx-auto px-6 text-center relative z-10 max-w-5xl">
            {{-- Headline --}}
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight drop-shadow-lg">
                Master Your Mind.<br class="hidden md:block"> Transform Your Life.
            </h1>

            {{-- Subheadline --}}
            <p class="text-lg md:text-2xl font-light mb-10 text-white/90">
                Stop waiting. Build strong <span class="font-semibold text-emerald-200">habits, focus, and routines</span> that actually move the needle.  
                <span class="font-bold text-emerald-100 block mt-2">🔥 Grab your free starter resources and take the first step today.</span>
            </p>


            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-6 mb-8">
                <a href="#free-products" class="px-8 py-4 bg-emerald-600 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:bg-emerald-700 transition text-lg w-full sm:w-auto">
                    Claim Free Resources
                </a>
                <a href="{{ route('products.index') }}" class="px-8 py-4 bg-white text-emerald-800 font-semibold rounded-full shadow-lg hover:shadow-xl hover:bg-gray-100 transition text-lg w-full sm:w-auto">
                    Browse All Products
                </a>
                <a href="{{ route('ascend.index') }}" class="px-8 py-4 bg-white/20 border border-white text-white backdrop-blur-md rounded-full font-medium hover:bg-white/30 transition text-lg w-full sm:w-auto">
                    Share Your Journey
                </a>
            </div>

            {{-- Auth Buttons --}}
            @guest
                <div class="flex flex-col sm:flex-row justify-center items-center gap-3 text-sm mt-4">
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-white/10 border border-white/20 rounded-full hover:bg-white/20 transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-emerald-500 text-white rounded-full shadow hover:bg-emerald-600 transition">
                        Register Free
                    </a>
                </div>
            @endguest

            {{-- Closing tagline --}}
            <p class="mt-12 text-sm text-white/70">
                Every moment you wait is a moment wasted. Take control now.
            </p>
        </div>
    </section>

    {{-- 🌟 FEATURED PRODUCT --}}
    @if(isset($featuredProduct))
    <section class="py-24 bg-gray-50 relative">
    <h2 class="text-3xl md:text-4xl font-extrabold text-emerald-800 mb-16 text-center uppercase tracking-wider">
        Top Pick for the Relentless
    </h2>

    <div class="container mx-auto px-6 flex flex-col md:flex-row gap-12 items-center">
        {{-- Product Image with modal --}}
        <div class="md:w-1/2 cursor-pointer" 
             x-data="{ open: false, index: 0, images: ['{{ asset('storage/' . $featuredProduct->cover_image) }}'] }">
            <img src="{{ asset('storage/' . $featuredProduct->cover_image) }}" 
                 alt="{{ $featuredProduct->title }}" 
                 class="rounded-2xl shadow-2xl object-cover w-full h-full transform hover:scale-105 transition duration-500"
                 loading="lazy"
                 @click="open = true">
        </div>

        {{-- Product Details --}}
        <div class="md:w-1/2 flex flex-col gap-6">
            <h2 class="text-4xl md:text-5xl font-extrabold text-emerald-800 leading-tight">
                {{ $featuredProduct->title }}
            </h2>

            <p class="text-lg md:text-xl text-gray-700 leading-relaxed">
                {!! strip_tags($featuredProduct->description) !!}
            </p>

            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-6 mt-4">
                {{-- Price --}}
                <span class="text-2xl md:text-3xl font-extrabold text-emerald-700">
                    @if ($featuredProduct->price == 0)
                        Free
                    @else
                        {{ display_price($featuredProduct->price) }}
                    @endif
                </span>

                {{-- CTA Button --}}
                <a href="{{ route('products.show', $featuredProduct->slug) }}" 
                   class="mt-3 sm:mt-0 inline-flex items-center justify-center px-8 py-4 bg-emerald-600 text-white font-semibold rounded-full shadow-lg hover:bg-emerald-700 hover:shadow-xl transition text-lg">
                    Get It Now
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                         d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <p class="mt-4 text-sm text-gray-500 italic">
                Learn, apply, and master – forever.
            </p>
        </div>
    </div>
</section>

    @endif

    {{-- 🎁 FREE RESOURCES --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-extrabold text-emerald-700 mb-4 uppercase tracking-wide">
                Multiple Free Resources Await You
            </h2>
            <p class="text-lg text-gray-600 mb-12 max-w-2xl mx-auto">
                Build unstoppable momentum with <strong>exclusive free downloads</strong>.  
                Choose the resource that matches your journey—or grab them all.
            </p>

            <div id="free-products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($freeProducts as $product)
                    @if ($product->status == 'published')
                        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl shadow-md hover:shadow-lg hover:scale-[1.02] transition overflow-hidden flex flex-col">
                            <div class="relative w-full h-52 bg-white flex items-center justify-center border-b border-emerald-100">
                                @if($product->cover_image)
                                    <img src="{{ asset('storage/' . $product->cover_image) }}" 
                                        alt="{{ $product->title }}" 
                                        class="object-contain w-full h-full p-6" 
                                        loading="lazy" />
                                @endif
                            </div>
                            <div class="flex-grow p-5 flex flex-col justify-between space-y-4">
                                <div>
                                    <h3 class="text-xl font-bold text-emerald-800 truncate mb-1">{{ $product->title }}</h3>
                                    <p class="text-sm text-gray-700 line-clamp-3">{!! strip_tags($product->description) !!}</p>
                                </div>
                                <div class="flex items-center justify-between pt-2">
                                    <span class="text-emerald-600 font-semibold text-base">Free</span>
                                    <a href="{{ route('products.show', $product->slug) }}"
                                    class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-full hover:bg-emerald-700 transition">
                                        Download Free
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-center text-gray-500 col-span-full">
                        No free resources available at this time. Check back soon!
                    </p>
                @endforelse
            </div>

            <div class="mt-8">
                <div class="flex justify-center">
                    {{ $freeProducts->onEachSide(1)->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>

    {{-- 🧰 LATEST DROPS --}}
    <section class="py-20 bg-emerald-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-emerald-700 mb-12 text-center uppercase tracking-wide">Latest Drops</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($latestProducts as $product)
                    @if ($product->status == 'published')
                        <div class="bg-white/60 backdrop-blur-md border border-emerald-100 rounded-2xl shadow-xl hover:scale-[1.02] hover:shadow-emerald-200 hover:border-emerald-300 transition overflow-hidden flex flex-col">
                            <div class="relative w-full h-52 bg-lime-50 flex items-center justify-center border-b border-emerald-100">
                                @if($product->cover_image)
                                    <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->title }}" class="object-contain w-full h-full p-6" loading="lazy" />
                                @endif
                            </div>
                            <div class="flex-grow p-5 flex flex-col justify-between space-y-4">
                                <div>
                                    <h3 class="text-xl font-bold text-emerald-800 truncate mb-1">{{ $product->title }}</h3>
                                    <p class="text-sm text-gray-700 line-clamp-3">{!! strip_tags($product->description) !!}</p>
                                </div>
                                <div class="flex items-center justify-between pt-2">
                                    <span class="text-emerald-800 font-semibold text-base">{{ display_price($product->price) }}</span>
                                    <a href="{{ route('products.show', $product->slug) }}"
                                    class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-full hover:bg-emerald-700 transition">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-center text-gray-500 col-span-full">No products available at this time. Check back soon!</p>
                @endforelse
            </div>
        </div>
    </section>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.location.search.includes("page=")) {
            const el = document.getElementById("free-products");
            if (el) {
                el.scrollIntoView({ behavior: "smooth" });
            }
        }
    });
</script>
@endsection
