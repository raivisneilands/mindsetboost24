@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <h1 class="text-2xl font-bold text-emerald-700 mb-6">Edit Your Review for {{ $product->title }}</h1>

    <form method="POST" action="{{ route('reviews.update', $product) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="rating" class="block text-sm font-medium">Rating</label>
            <select name="rating" id="rating" class="w-20 border rounded p-1">
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" @if($review->rating == $i) selected @endif>{{ $i }} ★</option>
                @endfor
            </select>
        </div>

        <div>
            <label for="review" class="block text-sm font-medium">Comment</label>
            <textarea name="review" id="review" rows="3" class="w-full border rounded p-2">{{ old('review', $review->review) }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('products.show', $product->slug) }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                Update Review
            </button>
        </div>
    </form>
</div>
@endsection
