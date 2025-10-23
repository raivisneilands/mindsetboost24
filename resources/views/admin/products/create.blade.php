@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Create Product</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="title" class="block font-semibold">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full border px-3 py-2 rounded">
            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold">Description</label>
            <input id="description" type="hidden" name="description" value="{{ old('description') }}" class="w-full border px-3 py-2 rounded">
            <trix-editor input="description" class="trix-content rounded bg-white border-gray-500"></trix-editor>
            @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block font-semibold">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mt-4">
            <label for="discount_price" class="block font-medium">Discount Price (€)</label>
            <input type="number" step="0.01" name="discount_price" id="discount_price" 
                class="border p-2 w-full rounded" value="{{ old('discount_price', $product->discount_price ?? '') }}">
        </div>

        <div class="mt-4 grid grid-cols-2 gap-4">
            <div>
                <label for="discount_start" class="block font-medium">Discount Start</label>
                <input type="date" name="discount_start" id="discount_start" 
                    class="border p-2 w-full rounded" value="{{ old('discount_start', $product->discount_start ?? '') }}">
            </div>

            <div>
                <label for="discount_end" class="block font-medium">Discount End</label>
                <input type="date" name="discount_end" id="discount_end" 
                    class="border p-2 w-full rounded" value="{{ old('discount_end', $product->discount_end ?? '') }}">
            </div>
        </div>


        <div class="mb-4">
            <label for="status" class="block font-semibold">Status</label>
            <select name="status" id="status" class="w-full border px-3 py-2 rounded">
                <option value="">-- Select Status --</option>
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
            </select>
            @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="categories" class="block font-semibold">Categories</label>
            <select name="categories[]" id="categories" multiple class="w-full border px-3 py-2 rounded">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('categories') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <label for="images" class="block font-medium text-sm text-gray-700">Preview Images</label>
        <input type="file" name="images[]" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />


        <div class="mb-4">
            <label for="cover_image" class="block font-semibold">Cover Image</label>
            <input type="file" name="cover_image" id="cover_image" class="w-full">
        </div>

        <div class="mb-4">
            <label for="file_path" class="block font-semibold">Product File</label>
            <input type="file" name="file_path" id="file_path" class="w-full">
        </div>

        {{-- SEO Optimization --}}

        <div class="mb-4">
            <label for="keywords" class="block font-medium">SEO Keywords (comma-separated)</label>
            <input type="text" name="keywords" id="keywords" class="w-full border rounded p-2" value="{{ old('keywords', $product->keywords ?? '') }}">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mb-6">Save Product</button>
    </form>
</div>
@endsection
