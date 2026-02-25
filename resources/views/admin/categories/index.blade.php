@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-lg p-6 sm:p-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Categories</h1>
            <a href="{{ route('admin.categories.create') }}" class="mt-4 sm:mt-0 bg-emerald-500 text-white px-4 py-2 rounded-xl hover:bg-emerald-600 transition">
                ➕ New Category
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-800 text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Slug</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $category->name }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $category->slug }}</td>
                            <td class="px-6 py-3 space-x-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection