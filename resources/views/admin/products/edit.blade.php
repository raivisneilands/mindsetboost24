@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white rounded-2xl shadow-md p-8">

    <h1 class="text-2xl font-bold mb-6 text-gray-900">Edit Product</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-4">
            <label for="title" class="block font-semibold text-gray-800">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" class="w-full border px-3 py-2 rounded">
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label class="block font-semibold text-gray-800">Description</label>
            <input id="description" type="hidden" name="description" value="{{ old('description', $product->description) }}">
            <trix-editor input="description" class="trix-content rounded bg-gray-50 border"></trix-editor>
        </div>

        {{-- Price & Discount --}}
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-800">Price (€)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-medium text-gray-800">Discount Price (€)</label>
                <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price ?? '') }}" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        {{-- Discount Dates --}}
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-800">Discount Start</label>
                <input type="date" name="discount_start" value="{{ old('discount_start', $product->discount_start ?? '') }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-medium text-gray-800">Discount End</label>
                <input type="date" name="discount_end" value="{{ old('discount_end', $product->discount_end ?? '') }}" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label class="block font-semibold text-gray-800">Status</label>
            <select name="status" class="w-full border px-3 py-2 rounded">
                <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $product->status) === 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        {{-- Categories --}}
        <div class="mb-4">
            <label class="block font-semibold text-gray-800">Categories</label>
            <select name="categories[]" multiple class="w-full border px-3 py-2 rounded">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Cover Image & Product File --}}
        <div class="mb-4">
            <label class="block font-semibold text-gray-800">Cover Image</label>
            @if($product->cover_image)
                <img src="{{ asset('storage/'.$product->cover_image) }}" class="h-32 mb-2 rounded">
            @endif
            <input type="file" name="cover_image" class="w-full">
        </div>

        {{-- Preview Images --}}
        <div class="mb-4">
            <label class="block font-semibold text-gray-800">Preview Images</label>
            @if($product->images->count())
                <div class="flex flex-wrap gap-2 my-2">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="h-20 rounded shadow">
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 my-2">No preview images uploaded yet.</p>
            @endif

            <input type="file" name="images[]" multiple class="w-full mt-2 border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-gray-800">Product File</label>
            @if($product->file_path)
                <span class="inline-block px-3 py-1 bg-gray-200 rounded mb-2">{{ basename($product->file_path) }}</span>
            @endif
            <input type="file" name="file_path" class="w-full">
        </div>

        {{-- SEO --}}
        <div class="mb-4">
            <label class="block font-medium text-gray-800">SEO Keywords</label>
            <input type="text" name="keywords" class="w-full border px-3 py-2 rounded" value="{{ old('keywords', $product->keywords ?? '') }}">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Product</button>
    </form>
</div>
@endsection