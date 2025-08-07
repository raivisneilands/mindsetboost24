@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white/10 backdrop-blur-md shadow-xl border border-emerald-300/40 rounded-2xl p-8 text-center transition-all duration-300">

    <!-- Profile Image -->
    @if($user->profile_image)
        <img src="{{ asset('storage/' . $user->profile_image) }}"
             alt="{{ $user->username }}'s Profile"
             class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-emerald-400 shadow-lg mb-4 hover:scale-105 transition-transform duration-200">
    @else
        <div class="w-32 h-32 mx-auto flex items-center justify-center rounded-full bg-white/20 border-4 border-emerald-400 shadow-lg mb-4">
            <svg class="w-14 h-14 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4zm0-2a4 4 0 110-8 4 4 0 010 8z"/>
            </svg>
        </div>
    @endif

    <!-- Username -->
    <h2 class="text-3xl font-extrabold text-emerald-500 tracking-wide mb-1">{{ $user->username }}</h2>

    <!-- Bio -->
    @if($user->bio)
        <p class="text-emerald-100/90 italic text-sm max-w-xl mx-auto mb-6">{{ $user->bio }}</p>
    @else
        <p class="text-gray-400 italic mb-6">No bio provided yet.</p>
    @endif

    <!-- Edit / Follow Button -->
    @auth
        @if(auth()->id() === $user->id)
            <a href="{{ route('profile.edit') }}"
               class="inline-block px-6 py-2 bg-emerald-600/90 text-white text-sm font-semibold rounded-full hover:bg-emerald-700 transition duration-200">
                ✏️ Edit Profile
            </a>        
        @else
            @php
                $isFollowing = auth()->check() ? auth()->user()->isFollowing($user) : false;
            @endphp

            <form method="POST" action="{{ route('users.follow', $user->id) }}" id="follow-form" class="inline">
                @csrf
                <button type="submit"
                        id="follow-btn"
                        data-following="{{ $isFollowing ? 'true' : 'false' }}"
                        class="px-6 py-2 rounded-full font-semibold text-sm transition bg-emerald-600 hover:bg-emerald-700 text-white duration-200">
                    {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                </button>
            </form>
        @endif
    @endauth

    <div id="follower-count" class="mt-3 text-sm text-emerald-700">Followers: {{ $user->followers()->count() }}</div>

    <!-- Posts Section -->
    <div class="mt-12">
        <h3 class="text-2xl font-semibold text-emerald-500 mb-4 border-b border-emerald-400/30 pb-2">🚀 The Ascend Posts</h3>

        @if($user->posts->count())
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
                @foreach($user->posts as $post)
                    <div class="bg-white/10 backdrop-blur-lg border border-emerald-300/30 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-5 flex flex-col">
                        @if($post->image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $post->image) }}"
                                     alt="Post Image"
                                     class="w-full h-52 object-cover rounded-xl border border-emerald-200 shadow-md">
                            </div>
                        @endif

                        <p class="text-gray-700 mb-4 text-sm text-left leading-relaxed whitespace-pre-line">{{ $post->content }}</p>

                        <div class="mt-auto flex justify-between items-center text-xs text-emerald-700">
                            <!-- Left: Likes + Comments -->
                            <div class="flex items-center gap-4">
                                <!-- Likes -->
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z" />
                                    </svg>
                                    <span>{{ $post->likes->count() }}</span>
                                </div>

                                <!-- Comments -->
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                    </svg>
                                    <span>{{ $post->comments->count() }}</span>
                                </div>
                            </div>

                            <!-- Center: Timestamp -->
                            <div class="text-emerald-700">
                                {{ $post->created_at->diffForHumans() }}
                            </div>

                            <!-- Right: Delete button (if owner) -->
                            @if($user->id === auth()->id())
                                <form action="{{ route('journey.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-500 hover:text-red-700 hover:underline transition font-semibold mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>

                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 mt-6">There are no posts yet...</p>
        @endif
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('follow-form');
    const btn = document.getElementById('follow-btn');
    const followerCountDiv = document.getElementById('follower-count');

    if (!form || !btn || !followerCountDiv) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        btn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({})
        })
        .then(res => {
            if (!res.ok) throw new Error("Network error");
            return res.json();
        })
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            btn.textContent = data.following ? 'Unfollow' : 'Follow';
            btn.dataset.following = data.following ? 'true' : 'false';
            followerCountDiv.textContent = `Followers: ${data.count}`;
        })
        .catch(err => {
            console.error('Follow toggle failed:', err);
        })
        .finally(() => {
            btn.disabled = false;
        });
    });
});
</script>
