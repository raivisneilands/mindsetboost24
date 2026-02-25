@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-emerald-600 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md p-6 sm:p-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Products</h1>
            <a href="{{ route('admin.products.create') }}" 
               class="mt-4 sm:mt-0 bg-emerald-500 text-white px-4 py-2 rounded-xl hover:bg-emerald-600 transition">
                + Add Product
            </a>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 uppercase text-sm tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Categories</th>
                        <th class="px-6 py-3 text-left">Price</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-gray-900">{{ $product->title }}</td>
                            <td class="px-6 py-3">
                                @foreach($product->categories as $category)
                                    <span class="inline-block bg-gray-200 px-2 py-1 text-xs rounded mr-1 text-gray-800">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-3 text-gray-900">€{{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-3 space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection