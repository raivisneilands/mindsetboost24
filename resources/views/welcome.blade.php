@extends('layouts.app')

@section('content')
<div class="bg-emerald-50 min-h-screen">

    {{-- 🔥 HERO: Attention-Grabbing Start --}}
    <section class="relative bg-cover bg-center bg-no-repeat text-white py-32 overflow-hidden" style="background-image: url('{{ asset('images/hero-background.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-br from-green-500/80 via-green-600/60 to-green-700/50"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent opacity-30 animate-pulse pointer-events-none"></div>

        <div class="container mx-auto px-6 text-center relative z-10 max-w-3xl">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight drop-shadow-xl text-shadow-lg">
                Discipline Wins. Your Transformation Starts Now.
            </h1>
            <p class="text-xl md:text-2xl font-light mb-10 text-white/90">
                Stop waiting. Start mastering your habits, focus, and results today.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="{{ route('products.index') }}" class="px-8 py-4 bg-white text-emerald-800 font-bold rounded-full shadow-lg hover:shadow-xl hover:bg-emerald-100 transition text-lg">
                    Browse Products
                </a>
                <a href="{{ route('ascend.index') }}" class="px-8 py-4 bg-white/20 border border-white text-white backdrop-blur-md rounded-full font-medium hover:bg-white/30 transition text-lg">
                    Share Your Journey
                </a>
                @guest
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-white/20 border border-white text-white backdrop-blur-md rounded-full font-medium hover:bg-white/30 transition text-lg">
                        Become One of the Few
                    </a>
                @endguest
            </div>

            <p class="mt-12  text-sm text-white/70">Every moment you wait is a moment wasted. Take control now.</p>

        </div>
    </section>

    {{-- Currency Selector --}}
    <form action="{{ route('currency.set') }}" method="POST" class="my-4 max-w-5xl mx-auto flex justify-center">
        @csrf
        <select
            name="currency"
            onchange="this.form.submit()"
            class="border border-gray-300 rounded-xl px-5 py-3 pr-10 bg-white text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 appearance-none transition"
            aria-label="Select currency"
        >
            @foreach(['EUR', 'USD', 'GBP', 'CAD', 'AUD'] as $cur)
                <option value="{{ $cur }}" {{ session('currency', 'EUR') === $cur ? 'selected' : '' }}>
                    {{ $cur }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- 🌟 FEATURED PRODUCT --}}
    @if(isset($featuredProduct))
    <section class="py-20 bg-gray-50 relative">
        <h2 class="text-3xl font-extrabold text-emerald-800 mb-24 text-center uppercase tracking-wide">
            Top Pick for the Relentless
        </h2>

        <div class="container mx-auto px-6 flex flex-col md:flex-row gap-12">
            <div class="md:w-1/2 cursor-pointer" x-data="{
                open: false,
                index: 0,
                images: ['{{ asset('storage/' . $featuredProduct->cover_image) }}'],
                next() { this.index = (this.index + 1) % this.images.length },
                prev() { this.index = (this.index - 1 + this.images.length) % this.images.length },
                close() { this.open = false }
            }">
                <img src="{{ asset('storage/' . $featuredProduct->cover_image) }}" alt="{{ $featuredProduct->title }}" 
                     class="rounded-xl shadow-lg object-cover w-full h-full" loading="lazy"
                     @click="open = true">

                {{-- Modal --}}
                <div x-show="open" x-transition class="fixed inset-0 bg-black/70 flex items-center justify-center z-50" @keydown.escape.window="close()" style="display: none;">
                    <button class="absolute top-6 right-6 text-white text-3xl font-bold" @click="close()">×</button>
                    <button class="absolute left-6 text-white text-3xl font-bold" @click="prev()">‹</button>
                    <img :src="images[index]" class="max-h-[80vh] max-w-[90vw] rounded-lg shadow-lg">
                    <button class="absolute right-6 text-white text-3xl font-bold" @click="next()">›</button>
                </div>
            </div>

            <div class="self-center md:w-1/2 flex flex-col gap-6">
                <h2 class="text-4xl font-bold text-emerald-800">{{ $featuredProduct->title }}</h2>
                <p class="text-lg text-gray-700 leading-relaxed">{!! strip_tags($featuredProduct->description) !!}</p>

                <div class="flex items-center gap-6">
                    <span class="text-2xl font-bold text-emerald-700">
                        @if ($featuredProduct->price == 0)
                            Absolutely Free
                        @else
                            {{ display_price($featuredProduct->price) }}
                        @endif
                    </span>
                    <a href="{{ route('products.show', $featuredProduct->slug) }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-full shadow hover:bg-emerald-700 transition">
                        Get It Now
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <p class="text-sm text-gray-500">Buy it once · Get it forever</p>
            </div>
        </div>
    </section>
    @endif

    {{-- 🧰 LATEST DROPS --}}
    <section class="py-20 bg-emerald-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-emerald-700 mb-12 text-center uppercase tracking-wide">Latest Drops</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($latestProducts as $product)
                    <div class="bg-white/60 backdrop-blur-md border border-emerald-100 rounded-2xl shadow-xl hover:scale-[1.02] hover:shadow-emerald-200 hover:border-emerald-300 transition overflow-hidden flex flex-col">
                        <div class="relative w-full h-52 bg-lime-50 flex items-center justify-center border-b border-emerald-100">
                            @if($product->cover_image)
                                <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->title }}" class="object-contain w-full h-full p-6" loading="lazy" />
                            @else
                                <span class="text-gray-400 text-sm">No Image</span>
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
                @empty
                    <p class="text-center text-gray-500 col-span-full">No products available at this time. Check back soon!</p>
                @endforelse
            </div>
        </div>
    </section>

</div>
@endsection
