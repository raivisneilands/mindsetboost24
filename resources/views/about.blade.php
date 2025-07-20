@extends('layouts.app')

@section('content')

    {{-- Hero Section --}}
    <section class="min-h-screen bg-gradient-to-br from-lime-200 via-emerald-100 to-green-200 flex items-center justify-center px-4">
        <div class="max-w-3xl text-center">
            <h1 class="text-5xl font-extrabold text-green-700 mb-6 leading-tight">
                Empowering You With Purposeful Digital Products
            </h1>
            <p class="text-xl text-gray-700 leading-relaxed">
                The right tools can transform lives. Our mission is to deliver impactful, minimalist digital products that help you grow — personally and professionally.
            </p>
        </div>
    </section>

    {{-- Section 1 --}}
    <section class="py-20 bg-emerald-100">
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row items-center gap-10 px-6">
            <div class="lg:w-1/2 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-lime-700 mb-4">Our Mission</h2>
                <p class="text-gray-800 text-lg leading-relaxed">
                    We’re building a space where anyone can access digital resources that spark action and drive clarity.
                    From habit trackers to growth journals, every product is crafted with care and intention.
                </p>
            </div>
            <div class="lg:w-1/2">
                <img src="{{ asset('images/mission.jpg') }}" alt="Mission Image" class="rounded-xl shadow-md w-full">
            </div>
        </div>
    </section>

    {{-- Section 2 --}}
    <section class="py-20 bg-lime-100">
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row-reverse items-center gap-10 px-6">
            <div class="lg:w-1/2 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-lime-700 mb-4">Growth With Every File</h2>
                <p class="text-gray-800 text-lg leading-relaxed">
                    Each product is more than just a file — it's a step forward. Our expanding library evolves with your needs,
                    staying focused on helping you build structure, improve mindset, and take ownership of your journey.
                </p>
            </div>
            <div class="lg:w-1/2">
                <img src="{{ asset('images/growth.jpg') }}" alt="Growth Image" class="rounded-xl shadow-md w-full">
            </div>
        </div>
    </section>

    {{-- Section 3 --}}
    <section class="py-20 bg-green-100">
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row items-center gap-10 px-6">
            <div class="lg:w-1/2 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-green-700 mb-4">Why We Exist</h2>
                <p class="text-gray-800 text-lg leading-relaxed">
                    We believe digital products should be functional, beautiful, and motivating. This isn’t just about downloads —
                    it’s about impact. We’re here to make tools that give you momentum, not noise.
                </p>
            </div>
            <div class="lg:w-1/2">
                <img src="{{ asset('images/impact.jpg') }}" alt="Impact Image" class="rounded-xl shadow-md w-full">
            </div>
        </div>
    </section>

@endsection
