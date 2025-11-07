@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="relative flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-600 text-white text-center px-6 overflow-hidden">

    {{-- Floating accent circles --}}
    <div class="absolute top-[-50px] left-[-50px] w-72 h-72 bg-white/10 rounded-full animate-pulse"></div>
    <div class="absolute bottom-[-60px] right-[-40px] w-80 h-80 bg-white/5 rounded-full animate-pulse"></div>

    {{-- Logo --}}
    <img src="{{ asset('favicon.png') }}" alt="Mindset Boost 24" class="w-20 h-20 mb-6 animate-bounce">

    {{-- Big 404 --}}
    <h1 class="text-7xl md:text-9xl font-extrabold mb-4 drop-shadow-lg">404</h1>

    {{-- Headline --}}
    <h2 class="text-3xl md:text-4xl font-semibold mb-4 drop-shadow-md">Page Not Found</h2>

    {{-- Description --}}
    <p class="text-lg md:text-xl text-white/90 mb-8 max-w-lg">
        Oops! The page you’re looking for doesn’t exist. Maybe you took a wrong turn in your journey to greatness.
    </p>

    {{-- Buttons --}}
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('home') }}" 
           class="px-6 py-3 bg-white text-emerald-600 font-bold rounded-full shadow-lg hover:bg-white/90 transition-all transform hover:-translate-y-1">
           ← Back to Home
        </a>
        <a href="{{ route('products.index') }}" 
           class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-full shadow-lg hover:bg-emerald-700 transition-all transform hover:-translate-y-1">
           Browse Products
        </a>
    </div>
</div>
@endsection
