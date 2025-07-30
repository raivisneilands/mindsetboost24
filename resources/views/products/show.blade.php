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

            @if ($product->images->count())
                <div class="mt-10">
                    <h2 class="text-xl font-semibold text-emerald-600 mb-4">Preview Images</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($product->images as $image)
                            <div class="overflow-hidden rounded-xl shadow-md hover:shadow-lg transition">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                    alt="Product Preview"
                                    class="w-full h-48 object-cover preview-image" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- The Modal -->
            <div id="modal"
                class="hidden fixed top-0 left-0 z-80 
                        w-screen h-screen bg-black/70 flex 
                        justify-center items-center">

                <!-- The close button -->
                <a class="fixed z-90 top-6 right-8 
                        text-white text-5xl font-bold" 
                href="javascript:void(0)"
                onclick="closeModal()">
                    ×
                </a>

                <!-- A big image will be displayed here -->
                <img id="modal-img"
                    class="max-w-[1000px] max-h-[1000px] object-cover"/>
            </div>

            <form action="{{ route('checkout.process', $product) }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" 
                    class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Buy Now
                </button>
            </form>

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
    }

    // This function is called when the close button is clicked
    function closeModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection
