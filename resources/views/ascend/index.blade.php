@extends('layouts.app')

@section('content')
<style>
    .fade-in {
        opacity: 0;
        transform: translateY(10px);
        animation: fadeInUp 0.4s ease-out forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div x-data="{ showGuidelines: localStorage.getItem('acceptedAscendGuidelines') !== 'true' }" x-init="if (showGuidelines) document.body.style.overflow = 'hidden'" x-effect="if (!showGuidelines) document.body.style.overflow = ''">

    {{-- ✅ Guidelines Modal --}}
    <div x-show="showGuidelines" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center">
        <div class="bg-white max-w-lg w-full mx-4 p-6 rounded-xl shadow-lg border border-emerald-200 text-gray-700">
            <h2 class="text-2xl font-bold text-emerald-700 mb-4">Welcome to The Ascend</h2>
            <p class="mb-3 text-sm">This is your space to track progress, share discipline wins, and stay accountable — alongside others on the same journey.</p>

            <ul class="list-disc pl-5 text-sm mb-4 space-y-1">
                <li>✅ Be respectful and constructive</li>
                <li>✅ Focus on progress, not perfection</li>
                <li>✅ No spam, promotion, or negativity</li>
                <li>✅ Uplift others with your consistency</li>
            </ul>

            <p class="text-xs text-gray-500 mb-6">By entering, you agree to uphold the spirit of growth, discipline, and encouragement.</p>

            <div class="flex justify-end gap-4">
                <button @click="window.location.href='{{ route('home') }}'" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded">
                    Decline
                </button>

                <button @click="localStorage.setItem('acceptedAscendGuidelines', 'true'); showGuidelines = false" class="px-4 py-2 text-sm bg-emerald-600 hover:bg-emerald-700 text-white rounded font-semibold">
                    Accept & Enter
                </button>
            </div>
        </div>
    </div>

    {{-- 🎯 Main Ascend Content --}}
    <div x-show="!showGuidelines">


<div class="max-w-2xl mx-auto p-4">
    <h2 class="text-4xl font-bold text-emerald-700 my-12 text-center">The Ascend</h2>

    <!-- Post form for logged in users -->
    @auth
    <form method="POST" action="{{ route('journey.store') }}" enctype="multipart/form-data" class="bg-white shadow-xl rounded-2xl p-6 mb-8 space-y-4 border border-emerald-100">
        @csrf

        <div class="flex items-start gap-4">
            {{-- Optional: Add user avatar here --}}
            <div class="hidden sm:block">
                <div class="w-10 h-10 rounded-full bg-emerald-200 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            </div>

            <div class="flex-1">
                <textarea
                    name="content"
                    class="w-full border border-gray-200 rounded-lg p-3 text-gray-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none resize-none placeholder-gray-400"
                    rows="4"
                    placeholder="Share your progress with others..."
                ></textarea>

                <div class="mt-3 flex items-center justify-between flex-wrap gap-4">
                    <label class="inline-flex items-center gap-2 cursor-pointer text-sm text-emerald-600 hover:text-emerald-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                        </svg>
                        <span>Attach Image</span>
                        <input type="file" name="image" class="hidden">
                    </label>

                    <button
                        type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm px-6 py-2 rounded-full shadow-md transition"
                    >
                        Post
                    </button>
                </div>
            </div>
        </div>
    </form>
    @else
        <h2>You must be logged in to post</h2>
    @endauth
    <!-- Post feed -->
    <div id="post-feed">
        @include('ascend._posts', ['posts' => $posts])
    </div>

    <div id="scroll-anchor" class="h-10"></div>
    <div id="loader" class="text-center text-emerald-500 py-4 hidden">Loading more...</div>

    <h2 class="text-emerald-500 mb-4 text-center">This is the end of the feed...</h2>

</div>

<script>
    let page = 1;
    let loading = false;

    const feed = document.getElementById('post-feed');
    const loader = document.getElementById('loader');

    const observer = new IntersectionObserver(async entries => {
        if (entries[0].isIntersecting && !loading) {
            loading = true;
            loader.classList.remove('hidden');
            page++;

            try {
                const res = await fetch(`?page=${page}`);
                const html = await res.text();
                const temp = document.createElement('div');
                temp.innerHTML = html;

                const newPosts = temp.querySelectorAll('.fade-in');
                if (newPosts.length > 0) {
                    newPosts.forEach(post => feed.appendChild(post));
                    loading = false;
                    loader.classList.add('hidden');
                } else {
                    observer.disconnect(); // No more posts
                    loader.remove();
                }
            } catch (err) {
                console.error('Failed to load posts', err);
            }
        }
    }, { threshold: 1.0 });

    observer.observe(document.getElementById('scroll-anchor'));
</script>
</div> {{-- Close x-data wrapper --}}
@endsection
