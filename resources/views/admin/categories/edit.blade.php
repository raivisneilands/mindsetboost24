@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-lg p-6 sm:p-8">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">
            {{ isset($category) ? 'Edit Category' : 'Add New Category' }}
        </h1>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="space-y-4">
                <div>
                    <label for="name" class="block font-semibold text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl shadow">
                    {{ isset($category) ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection