@extends('layouts.app')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-gradient-to-r from-emerald-500 via-lime-500 to-green-500">
    <div class="text-center text-white px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            Build Better. Live Smarter.
        </h1>
        <p class="text-lg md:text-xl mb-8 max-w-xl mx-auto">
            Explore digital products that boost productivity, simplify life, and power up your potential.
        </p>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-white text-teal-600 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition">
                Get Started
            </a>
            <a href="#products" class="inline-block px-6 py-3 border border-white font-semibold rounded-lg hover:bg-white hover:text-teal-600 transition">
                Browse Products
            </a>
        </div>
    </div>
</section>
@endsection
