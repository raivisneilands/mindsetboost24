@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>

    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
    <p><strong>Category:</strong> {{ $product->category->name ?? '—' }}</p>
    <p><strong>File URL:</strong> <a href="{{ $product->file_url }}" class="text-blue-600 underline" target="_blank">{{ $product->file_url }}</a></p>
</div>
@endsection
