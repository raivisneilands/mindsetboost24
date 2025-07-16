@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block font-semibold">Name</label>
            <input name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
        </div>

        <div>
            <label class="block font-semibold">Price</label>
            <input name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">File URL</label>
            <input name="file_url" type="url" value="{{ old('file_url', $product->file_url) }}" class="w-full border rounded px-3 py-2">
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update Product</button>
    </form>
</div>
@endsection
