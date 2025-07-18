@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block font-semibold">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" class="w-full border px-3 py-2 rounded">
            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold">Description</label>
            <textarea name="description" id="description" class="w-full border px-3 py-2 rounded">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block font-semibold">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label for="status" class="block font-semibold">Status</label>
            <select name="status" id="status" class="w-full border px-3 py-2 rounded">
                <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $product->status) === 'published' ? 'selected' : '' }}>Published</option>
            </select>
            @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="categories" class="block font-semibold">Categories</label>
            <select name="categories[]" id="categories" multiple class="w-full border px-3 py-2 rounded">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="cover_image" class="block font-semibold">Cover Image</label>
            <input type="file" name="cover_image" id="cover_image" class="w-full">
        </div>

        <div class="mb-4">
            <label for="file_path" class="block font-semibold">Product File</label>
            <input type="file" name="file_path" id="file_path" class="w-full">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Product</button>
    </form>
</div>
@endsection
