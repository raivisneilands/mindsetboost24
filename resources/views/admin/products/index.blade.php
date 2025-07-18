@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Product</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Categories</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $product->title }}</td>
                        <td class="px-4 py-2">
                            @foreach($product->categories as $category)
                                <span class="inline-block bg-gray-200 px-2 py-1 text-xs rounded">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-4 text-center">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
