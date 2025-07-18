@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        @if($product->cover_image)
            <img src="{{ asset('storage/' . $product->cover_image) }}"
                 class="w-full h-96 object-cover" alt="{{ $product->title }}">
        @endif

        <div class="p-6">
            <h1 class="text-3xl font-bold text-lime-700 mb-4">{{ $product->title }}</h1>

            <p class="text-gray-700 mb-4">{{ $product->description }}</p>

            <div class="mb-4">
                <span class="text-green-700 font-semibold text-lg">
                    ${{ number_format($product->price, 2) }}
                </span>
            </div>

            @if($product->categories->count())
                <div class="mb-4">
                    <span class="text-sm text-gray-600">Categories:</span>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach ($product->categories as $category)
                            <span class="bg-lime-100 text-lime-700 px-3 py-1 rounded-full text-xs">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(Str::endsWith($product->file_path, '.pdf'))
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-lime-700 mb-2">Preview:</h2>
                    <iframe src="{{ asset('storage/' . $product->file_path) }}" class="w-full h-[500px]" frameborder="0"></iframe>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
