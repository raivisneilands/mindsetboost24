@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-emerald-600">🎁 Product Packs</h1>
        <a href="{{ route('admin.packs.create') }}" class="bg-emerald-500 text-white px-4 py-2 rounded-xl hover:bg-emerald-600 transition">
            + Create New Pack
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6 divide-y divide-gray-200">
        @forelse ($packs as $pack)
            <div class="py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $pack->title }}</h2>
                        <p class="text-sm text-gray-500 mb-1">{{ $pack->products->count() }} products • {{ $pack->discount_percent }}% off</p>
                        <p class="text-sm text-gray-700">Final Price: <span class="font-semibold">{{ number_format($pack->final_price, 2) }} €</span></p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.packs.edit', $pack) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.packs.destroy', $pack) }}" method="POST" onsubmit="return confirm('Delete this pack?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-10">No product packs yet.</p>
        @endforelse
    </div>
</div>
@endsection
