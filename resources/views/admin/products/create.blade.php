@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Add Product</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Name</label>
            <input name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block font-semibold">Price</label>
            <input name="price" type="number" step="0.01" value="{{ old('price') }}" class="w-full border rounded px-3 py-2" required>
            @error('price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">File URL (for digital download)</label>
            <input name="file_url" type="url" value="{{ old('file_url') }}" class="w-full border rounded px-3 py-2">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Product</button>
    </form>
</div>
@endsection
