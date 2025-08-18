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
<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="shadow-xl rounded-xl overflow-hidden">
        {{-- Cover Image --}}
        @if($product->cover_image)
            <img src="{{ asset('storage/' . $product->cover_image) }}" 
                 class="w-full h-96 object-cover" 
                 alt="{{ $product->title }}">
        @endif

        <div class="p-6 space-y-4">
            {{-- Title --}}
            <h1 class="text-3xl font-bold text-emerald-700">{{ $product->title }}</h1>

            {{-- Price & Buy Button --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <span class="text-emerald-800 font-bold text-2xl select-none">
                    @if ($product->price == 0)
                        Free
                    @else
                        {{ display_price($product->price) }} - Lifetime Access
                    @endif
                    </span>

                <form action="{{ route('checkout.process', $product) }}" method="POST" class="w-full md:w-auto">
                    @csrf
                    <button type="submit" 
                        class="w-full md:w-auto px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition">
                        @if ($product->price == 0)
                            Download Now
                        @else
                            Buy now
                        @endif
                    </button>
                </form>
            </div>

            <p class="text-sm text-gray-500 mt-2">
                <strong>Note:</strong> All payments are processed in EUR. Prices shown in other currencies (USD, GBP, etc.) are approximate conversions for your convenience. Your bank may apply a small conversion fee and the final amount may differ slightly from the estimate.
            </p>            
            <p class="text-sm text-gray-500 mt-2">
                <strong>Refund Policy:</strong> All products are digital and delivered instantly. Once your purchase is completed, refunds cannot be issued. If you experience any issues accessing your download, contact us at support@mindsetboost24.com, and we’ll help you resolve it.
            </p>

            {{-- Categories --}}
            @if($product->categories->count())
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach ($product->categories as $category)
                        <span class="bg-emerald-200 text-emerald-700 px-3 py-1 rounded-full text-xs">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            {{-- Description --}}
            <div class="trix-content text-gray-700">
                {!! $product->description !!}
            </div>

            {{-- Preview Images --}}
            @if($product->images->count())
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-emerald-600 mb-4">Preview Images</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($product->images as $index => $image)
                            <div class="overflow-hidden rounded-xl shadow-md hover:shadow-lg transition">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="Product Preview"
                                     class="w-full h-48 object-cover preview-image cursor-pointer transition-transform duration-300 hover:scale-110"
                                     data-index="{{ $index }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Reviews --}}
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4 text-emerald-600">User Reviews</h2>

                @php $average = number_format($product->reviews->avg('rating'), 1); @endphp
                <div class="flex items-center text-yellow-500 text-sm mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= round($average)) ★ @else ☆ @endif
                    @endfor
                    <span class="ml-2 text-gray-500">({{ $product->reviews->count() }})</span>
                </div>

                @forelse($product->reviews as $review)
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
                                <form action="{{ route('reviews.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete your review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-400">No reviews yet. Be the first to leave one!</p>
                @endforelse
            </div>

            {{-- Leave Review --}}
            @auth
                <div class="mt-6 p-4 border rounded-xl bg-gray-100">
                    <h3 class="text-lg font-semibold mb-3 text-emerald-700">Leave a Review</h3>
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

{{-- Modal --}}
<div id="modal" class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex justify-center items-center px-4">
    <button class="absolute top-4 right-4 text-white text-4xl font-bold" onclick="closeModal()">×</button>
    <button id="prevBtn" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-white text-4xl px-4 py-2 hover:text-lime-400 select-none">‹</button>
    <img id="modal-img" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-lg" />
    <button id="nextBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-white text-4xl px-4 py-2 hover:text-lime-400 select-none">›</button>
</div>

{{-- Modal JS --}}
<script>
    const images = document.querySelectorAll('.preview-image');
    const modal = document.getElementById("modal");
    const modalImg = document.getElementById("modal-img");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const imageSources = Array.from(images).map(img => img.src);
    let currentIndex = 0;

    function showModal(index) {
        currentIndex = index;
        modal.classList.remove('hidden');
        modalImg.src = imageSources[currentIndex];
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    images.forEach((img, i) => img.addEventListener('click', () => showModal(i)));

    prevBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        currentIndex = (currentIndex - 1 + imageSources.length) % imageSources.length;
        modalImg.src = imageSources[currentIndex];
    });

    nextBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        currentIndex = (currentIndex + 1) % imageSources.length;
        modalImg.src = imageSources[currentIndex];
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape" && !modal.classList.contains('hidden')) {
            closeModal();
        }
        if (e.key === "ArrowLeft" && !modal.classList.contains('hidden')) {
            currentIndex = (currentIndex - 1 + imageSources.length) % imageSources.length;
            modalImg.src = imageSources[currentIndex];
        }
        if (e.key === "ArrowRight" && !modal.classList.contains('hidden')) {
            currentIndex = (currentIndex + 1) % imageSources.length;
            modalImg.src = imageSources[currentIndex];
        }
    });
</script>

@endsection
