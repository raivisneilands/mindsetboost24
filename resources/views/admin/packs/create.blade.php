@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-emerald-600 mb-6">
        {{ isset($pack) ? 'Edit Product Pack' : 'Create Product Pack' }}
    </h1>

    <form method="POST" action="{{ isset($pack) ? route('admin.packs.update', $pack) : route('admin.packs.store') }}">
        @csrf
        @if(isset($pack))
            @method('PUT')
        @endif

        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" name="title" value="{{ old('title', $pack->title ?? '') }}" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-500">
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-500">{{ old('description', $pack->description ?? '') }}</textarea>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2">Discount (%)</label>
            <input type="number" name="discount_percent" step="0.1" min="0" max="100"
                   value="{{ old('discount_percent', $pack->discount_percent ?? 0) }}"
                   class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-500">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Select Products</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach($products as $product)
                    <label class="flex items-center space-x-2 border rounded-xl p-2 hover:bg-gray-50">
                        <input type="checkbox" name="products[]" value="{{ $product->id }}"
                               @checked(isset($pack) && $pack->products->contains($product->id))>
                        <span>{{ $product->title }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <button class="bg-emerald-500 text-white px-6 py-3 rounded-xl hover:bg-emerald-600 transition">
            {{ isset($pack) ? 'Update Pack' : 'Create Pack' }}
        </button>
    </form>
</div>
@endsection
