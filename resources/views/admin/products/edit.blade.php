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
            <label class="block font-semibold ">Description</label>
            <input id="description" type="hidden" name="description" value="{{ old('description', $product->description) }}">
            <trix-editor input="description" class="trix-content rounded"></trix-editor>
        </div>

        <div class="mb-4">
            <label for="price" class="block font-semibold">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" class="w-full border px-3 py-2 rounded">
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

        <label for="images" class="block font-medium text-sm text-gray-700">Preview Images</label>
        <input type="file" name="images[]" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />


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

        {{-- SEO Optimization --}}
        <div class="mb-4">
            <label for="keywords" class="block font-medium">SEO Keywords (comma-separated)</label>
            <input type="text" name="keywords" id="keywords" class="w-full border rounded p-2" value="{{ old('keywords', $product->keywords ?? '') }}">
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
