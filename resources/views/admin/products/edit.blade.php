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

        {{-- Cover Image Upload --}}
        <div class="mb-4">
            <label for="cover_image" class="block font-semibold">Cover Image</label>

            @if ($product->cover_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->cover_image) }}" alt="Cover Image" class="h-32 rounded shadow">
                </div>
            @endif

            <input type="file" name="cover_image" id="cover_image" class="w-full">
        </div>

        {{-- Product File --}}
        <div class="mb-4">
            <label class="block font-semibold">Current Product File</label>

            @if ($product->file_path)
                <div class="mb-2">
                    <span class="inline-block px-3 py-1 bg-gray-200 rounded">
                        {{ basename($product->file_path) }}
                    </span>
                </div>
            @else
                <p class="text-gray-500">No file uploaded yet.</p>
            @endif

            <button type="button" id="changeFileBtn" class="text-green-600 underline mb-2">
                Change File
            </button>

            <input type="file" name="file_path" id="file_path" class="w-full hidden" disabled>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Product</button>
    </form>
</div>

<script>
    const changeFileBtn = document.getElementById('changeFileBtn');
    const fileInput = document.getElementById('file_path');

    changeFileBtn.addEventListener('click', () => {
        if (fileInput.disabled) {
            fileInput.disabled = false;
            fileInput.classList.remove('hidden');
            changeFileBtn.textContent = 'Cancel Change';
        } else {
            fileInput.disabled = true;
            fileInput.classList.add('hidden');
            changeFileBtn.textContent = 'Change File';
            fileInput.value = null; // clear selected file
        }
    });
</script>
@endsection
