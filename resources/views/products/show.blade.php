{{-- resources/views/products/show.blade.php --}}

@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    <meta name="keywords" content="{{ $product->keywords }}">
    <meta property="og:title" content="{{ $product->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    <meta property="og:image" content="{{ asset('storage/' . $product->cover_image) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
@endpush

@section('content')

<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        @if($product->cover_image)
            <img src="{{ asset('storage/' . $product->cover_image) }}"
                 class="w-full h-96 object-cover" alt="{{ $product->title }}">
        @endif

        <div class="p-6">
            <h1 class="text-3xl font-bold text-lime-700 mb-4">{{ $product->title }}</h1>
            <div class="trix-content">
                <p class="text-gray-700 mb-4">{!! $product->description !!}</p>
            </div>
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

            @if ($product->images->count())
                <div class="mt-10">
                    <h2 class="text-xl font-semibold text-emerald-600 mb-4">Preview Images</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($product->images as $image)
                            <div class="overflow-hidden rounded-xl shadow-md hover:shadow-lg transition">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                    alt="Product Preview"
                                    class="w-full h-48 object-cover preview-image hover:cursor-pointer transition-all duration-300 hover:scale-110" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- The Modal -->
            <div id="modal"
                class="hidden fixed inset-0 z-80 bg-black/70 backdrop-blur-sm 
                        flex justify-center items-center">

                <!-- Close button -->
                <a class="fixed z-90 top-6 right-8 text-white text-4xl font-bold"
                href="javascript:void(0)" onclick="closeModal()">×</a>

                <!-- Modal Image -->
                <img id="modal-img"
                    class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-lg" />
            </div>

            <form action="{{ route('checkout.process', $product) }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" 
                    class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Buy Now
                </button>
            </form>
            @if ($product->reviews->count())
                <div class="mt-10">
                    <h2 class="text-xl font-semibold mb-4 text-emerald-600">User Reviews</h2>

                    @foreach ($product->reviews as $review)
                        <div class="mb-4 p-4 border rounded-xl bg-gray-50 shadow-sm">
                            <div class="flex justify-between items-center mb-1">
                                <strong>{{ $review->user->name }}</strong>
                                <span class="text-yellow-500">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </span>
                            </div>
                            @if ($review->review)
                                <p class="text-sm text-gray-700">{{ $review->review }}</p>
                            @endif
                            @if ($review->user_id === auth()->id())
                                <div class="text-sm text-right mt-2 space-x-2">
                                    <a href="{{ route('reviews.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('reviews.destroy', $product) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Delete your review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <h2 class="text-xl my-4 text-gray-400">There are no reviews for this product yet. Be the first one to leave one</h2>
            @endif    

            @auth
                <div class="mt-10">
                    <h2 class="text-xl font-semibold mb-3 text-emerald-700">Leave a Review</h2>

                    <form method="POST" action="{{ route('reviews.store', $product) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="rating" class="block text-sm font-medium">Rating</label>
                            <select name="rating" id="rating" class="w-20 border rounded p-1">
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} ★</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="review" class="block text-sm font-medium">Comment (optional)</label>
                            <textarea name="review" id="review" rows="3" class="w-full border rounded p-2"></textarea>
                        </div>

                        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                            Submit Review
                        </button>
                    </form>
                </div>
            @endauth

        </div>
    </div>
</div>
<script>
    // Get all the img elements in the grid
    var images = document.querySelectorAll('.preview-image');

    // Loop through each img element
    images.forEach(function (img) {
        
    // Add a click event listener to each img element
        img.addEventListener('click', function () {
            showModal(img.src);
        });
    });

    // Get the modal by id
    var modal = document.getElementById("modal");

    // Get the modal image tag
    var modalImg = document.getElementById("modal-img");

    // This function is called when a small image is clicked
    function showModal(src) {
        modal.classList.remove('hidden');
        modalImg.src = src;
        document.body.classList.add('overflow-hidden');
    }

    // This function is called when the close button is clicked
    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
