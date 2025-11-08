@extends('layouts.app')

@section('title', 'Home | Mindset Boost 24')
@section('meta_description', 'Mindset Boost 24 helps you build unstoppable discipline, focus, and routines with digital tools, challenges, and guides.')

@section('content')
<nav 
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
    :class="scrolled ? 'bg-black/60 backdrop-blur-lg shadow-lg border-b border-white/10' : 'bg-transparent'"
    class="fixed top-0 left-0 w-full z-50 text-white transition-all duration-500 ease-in-out"
>
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="text-2xl font-extrabold flex items-center gap-2 group">
            <img src="{{ asset('favicon.png') }}" alt="Mindset Boost 24" class="w-10 h-10 transition-transform duration-500 group-hover:rotate-6">
            <span class="tracking-tight group-hover:text-emerald-400 transition-colors">Mindset Boost 24</span>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden md:flex items-center gap-7">
            <a href="{{ route('products.index') }}" class="relative hover:text-emerald-400 transition font-medium after:absolute after:bottom-[-6px] after:left-0 after:w-0 after:h-[2px] after:bg-emerald-400 hover:after:w-full after:transition-all after:duration-300">
                Products
            </a>
            <a href="{{ route('packs.index') }}" class="relative hover:text-emerald-400 transition font-medium after:absolute after:bottom-[-6px] after:left-0 after:w-0 after:h-[2px] after:bg-emerald-400 hover:after:w-full after:transition-all after:duration-300">
                Packs
            </a>
            <a href="#free-products" class="relative hover:text-emerald-400 transition font-medium after:absolute after:bottom-[-6px] after:left-0 after:w-0 after:h-[2px] after:bg-emerald-400 hover:after:w-full after:transition-all after:duration-300">
                Free Tools
            </a>

            {{-- Auth --}}
            @auth
                <div x-data="{ dropdown: false }" class="relative">
                    <button @click="dropdown = !dropdown" class="flex items-center gap-2 font-semibold text-white hover:text-emerald-400 transition">
                        @if (auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                                class="w-8 h-8 rounded-full object-cover border border-white/30 shadow-sm">
                        @else
                            <svg class="w-8 h-8 rounded-full bg-white/90 p-1 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4zm0-2a4 4 0 110-8 4 4 0 010 8z"/>
                            </svg>
                        @endif
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 mt-[2px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div
                        x-show="dropdown" 
                        @click.away="dropdown = false"
                        x-transition
                        class="absolute right-0 mt-3 w-52 bg-white/95 backdrop-blur-lg shadow-2xl rounded-xl py-2 border border-gray-100"
                    >
                        <a href="{{ route('profile.show', auth()->user()->username) }}" class="block px-4 py-2 hover:bg-emerald-50 text-gray-700">My Profile</a>
                        <a href="{{ route('purchases.index') }}" class="block px-4 py-2 hover:bg-emerald-50 text-gray-700">My Purchases</a>
                        <a href="{{ route('journal.index') }}" class="block px-4 py-2 hover:bg-emerald-50 text-gray-700">My Journal</a>
                        @if(auth()->user()->is_admin ?? false)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 font-semibold text-emerald-600 hover:bg-emerald-100">
                                🛠 Admin Dashboard
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth

            {{-- Guest --}}
            @guest
                <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-500 text-white rounded-full font-semibold hover:bg-emerald-600 transition shadow-md hover:shadow-lg">Sign Up</a>
                <a href="{{ route('login') }}" class="px-4 py-2 border border-white/60 text-white rounded-full font-semibold hover:bg-white hover:text-emerald-700 transition">Login</a>
            @endguest
        </div>

        {{-- Mobile Button --}}
        <div class="md:hidden flex items-center">
            <button @click="open = !open" class="focus:outline-none">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div 
        x-show="open" 
        x-transition
        class="md:hidden bg-black/80 backdrop-blur-lg border-t border-white/10 text-white"
    >
        <a href="{{ route('products.index') }}" class="block px-6 py-3 hover:bg-emerald-600/30 transition">Products</a>
        <a href="{{ route('packs.index') }}" class="block px-6 py-3 hover:bg-emerald-600/30 transition">Packs</a>
        <a href="#free-products" class="block px-6 py-3 hover:bg-emerald-600/30 transition">Free Tools</a>

        @guest
            <a href="{{ route('register') }}" class="block px-6 py-3 bg-emerald-500 text-white font-semibold hover:bg-emerald-600 transition">Sign Up</a>
            <a href="{{ route('login') }}" class="block px-6 py-3 border-t border-white/10 text-white font-semibold hover:bg-emerald-500/30 transition">Login</a>
        @endguest
    </div>
</nav>




<div class="bg-emerald-50 min-h-screen">

    {{-- 🔥 HERO: Attention-Grabbing Start --}}
    <section class="relative bg-cover bg-center bg-no-repeat text-white py-32 overflow-hidden" 
        style="background-image: url('{{ asset('images/hero-background.jpg') }}');">

        {{-- Gradient overlays --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-800/80 via-emerald-900/80 to-black/70"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent opacity-40 pointer-events-none"></div>

        <div class="container mx-auto px-6 text-center relative z-10 max-w-5xl">

            {{-- Headline --}}
            <h1 class="font-extrabold tracking-tight mb-6 leading-tight drop-shadow-lg text-3xl sm:text-4xl md:text-5xl">
                Build Relentless Discipline, Focus, Routines
            </h1>

            {{-- Subheadline --}}
            <p class="text-lg md:text-xl font-light text-white/90 mb-10 max-w-3xl mx-auto">
                Stop drifting. Strengthen your mindset, one system at a time — and see your discipline transform into daily momentum.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                <a href="{{ route('products.index') }}" 
                class="px-8 py-4 bg-white text-emerald-800 font-semibold rounded-full shadow-lg hover:shadow-xl hover:bg-gray-100 transition text-lg w-full sm:w-auto">
                    Browse All Products
                </a>

                <a href="{{ route('packs.show', 'mindset-boost-free-starter-pack') }}" 
                class="px-8 py-4 bg-emerald-500/20 border border-white text-white rounded-full backdrop-blur-md font-medium hover:bg-white/20 transition text-lg w-full sm:w-auto">
                    Get Started Here
                </a>
            </div>

            @guest
                <div class="mt-10 text-sm sm:text-base text-white/80">
                    🎁 Create a free account and unlock your first downloads instantly.
                </div>
            @endguest

            <p class="mt-12 italic text-white/60">
                Every moment you wait is a step backward. Begin your ascent now.
            </p>
        </div>
    </section>

    {{-- 💪 WHAT YOU’LL BUILD --}}
    <section class="py-24 bg-white text-center">
        <div class="container mx-auto px-6 max-w-5xl">
            <h2 class="text-3xl md:text-4xl font-extrabold text-emerald-800 mb-6 uppercase tracking-wide">
                What You’ll Build With Mindset Boost 24
            </h2>
            <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto">
                These tools aren’t just downloads — they’re blueprints for a stronger, more focused version of you.  
                Step by step, you’ll create habits that outlast motivation.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 text-left">
                <div class="p-8 bg-emerald-50 border border-emerald-100 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-emerald-800 mb-2">Unbreakable Discipline</h3>
                    <p class="text-gray-700">Master the art of consistency. Build the discipline to act even when you don’t feel like it.</p>
                </div>
                <div class="p-8 bg-emerald-50 border border-emerald-100 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-emerald-800 mb-2">Laser-Sharp Focus</h3>
                    <p class="text-gray-700">Cut distractions and train your mind to lock onto what truly matters each day.</p>
                </div>
                <div class="p-8 bg-emerald-50 border border-emerald-100 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-emerald-800 mb-2">Sustainable Routines</h3>
                    <p class="text-gray-700">Build morning and evening systems that keep you on track without burnout.</p>
                </div>
            </div>

            <div class="mt-12">
                <a href="{{ route('products.index') }}" 
                class="inline-block px-8 py-4 bg-emerald-600 text-white font-semibold rounded-full shadow-lg hover:bg-emerald-700 transition text-lg">
                    Start Building Today
                </a>
            </div>
        </div>
    </section>



    {{-- 🌟 FEATURED PRODUCT --}}
    @if(isset($featuredProduct))
    <section class="py-24 bg-gray-50 relative">
        <h2 class="text-3xl md:text-4xl font-extrabold text-emerald-800 mb-16 text-center uppercase tracking-wider">
            Featured Self-Discipline & Productivity Product
        </h2>

        <div class="container mx-auto px-6 flex flex-col md:flex-row gap-12 items-center">
            {{-- Product Image with modal --}}
            <div class="md:w-1/2 cursor-pointer" 
                x-data="{ open: false, index: 0, images: ['{{ asset('storage/' . $featuredProduct->cover_image) }}'] }">
                <img src="{{ asset('storage/' . $featuredProduct->cover_image) }}" 
                    alt="{{ $featuredProduct->title }} - Productivity Digital Resource" 
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
                        @if ($featuredProduct->active_price == 0)
                            Free
                        @else
                            @if ($featuredProduct->is_discount_active)
                                <p class="text-lg">
                                    <span class="line-through text-gray-400 text-sm">{{ display_price($featuredProduct->price) }}</span>
                                    <br>
                                    <span class="text-emerald-500 font-bold text-2xl">{{ display_price($featuredProduct->active_price) }}</span>
                                    <br>
                                    <span class="text-sm text-red-500/60">Sale ends {{ $featuredProduct->discount_end->format('M j') }}</span>
                                </p>
                            @else
                                <p class="text-lg font-semibold">{{ display_price($featuredProduct->active_price) }}</p>
                            @endif
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
                Free Discipline & Focus Resources to Boost Your Mindset
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

    {{-- 🏆 TOP DOWNLOADS SECTION --}}
    @if($topDownloads->count() > 0)
    <section class="py-20 bg-gray-100 border-t border-gray-200">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-emerald-700 mb-12 text-center uppercase tracking-wide">
                Top Downloads by Community 
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($topDownloads as $product)
                    <div class="bg-white/70 backdrop-blur-md border border-emerald-100 rounded-2xl shadow-lg hover:scale-[1.02] hover:shadow-emerald-200 hover:border-emerald-300 transition overflow-hidden flex flex-col">
                        <div class="relative w-full h-52 bg-emerald-50 flex items-center justify-center border-b border-emerald-100">
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
                                <span class="text-emerald-800 font-semibold text-base">
                                    @if ($product->active_price == 0)
                                        Free
                                    @else
                                        {{ display_price($product->active_price) }}
                                    @endif
                                </span>
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-full hover:bg-emerald-700 transition">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    {{-- 🧰 LATEST DROPS --}}
    <section class="py-20 bg-emerald-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-emerald-700 mb-12 text-center uppercase tracking-wide">New Digital Tools & Challenges for Building Discipline</h2>
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
                                    <span class="text-emerald-800 font-semibold text-base">
                                        @if ($product->active_price == 0)
                                            Free
                                        @else
                                            @if ($product->is_discount_active)
                                                <p class="text-lg">
                                                    <span class="line-through text-gray-400 text-sm">{{ display_price($product->price) }}</span>
                                                    <span class="text-emerald-500 font-bold text-2xl">{{ display_price($product->active_price) }}</span>
                                                    <br>
                                                    <span class="text-sm text-red-500/60">Sale ends {{ $product->discount_end->format('M j') }}</span>
                                                </p>
                                            @else
                                                <p class="text-lg font-semibold">{{ display_price($product->active_price) }}</p>
                                            @endif
                                        @endif
                                    </span>
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
