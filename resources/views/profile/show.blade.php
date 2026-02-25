@extends('layouts.app')

@section('title', 'My Profile | Mindset Boost 24')
@section('meta_description', 'Manage your account, track your progress, and personalize your experience on Mindset Boost 24.')

@section('content')
<div class="max-w-4xl mx-auto mt-12 p-6 md:p-10 bg-white/10 backdrop-blur-md rounded-3xl border border-emerald-300/30 shadow-xl transition-all duration-300">

    {{-- Profile Header --}}
    <div class="flex flex-col md:flex-row items-center gap-6 md:gap-10 text-center md:text-left">
        {{-- Profile Image --}}
        @if($user->profile_image)
            <img src="{{ asset('storage/' . $user->profile_image) }}"
                 alt="{{ $user->username }}'s Profile"
                 class="w-32 h-32 rounded-full object-cover border-4 border-emerald-400 shadow-lg hover:scale-105 transition-transform duration-200">
        @else
            <div class="w-32 h-32 flex items-center justify-center rounded-full bg-white/20 border-4 border-emerald-400 shadow-lg">
                <svg class="w-14 h-14 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4zm0-2a4 4 0 110-8 4 4 0 010 8z"/>
                </svg>
            </div>
        @endif

        {{-- User Info --}}
        <div class="flex-1 space-y-2">
            <h2 class="text-3xl md:text-4xl font-extrabold text-emerald-500 tracking-wide">{{ $user->username }}</h2>
            <p class="text-gray-400 italic text-sm md:text-base max-w-md">
                {{ $user->bio ?? 'No bio provided yet.' }}
            </p>

            {{-- Edit / Follow Button --}}
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
            <div id="follower-count" class="text-sm text-emerald-700 mt-1">Followers: {{ $user->followers()->count() }}</div>
        </div>
    </div>

    {{-- Badges --}}
    @if($user->badges->count())
        <div class="mt-8">
            <h3 class="text-xl md:text-2xl font-semibold text-emerald-500 mb-4">🏅 Badges</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($user->badges as $badge)
                    <div class="flex flex-col items-center p-3 rounded-xl bg-emerald-700/20 border border-emerald-400/40 shadow-md hover:shadow-lg transition">
                        <span class="text-3xl mb-1">{{ $badge->icon }}</span>
                        <p class="text-sm text-emerald-700 font-semibold text-center">{{ $badge->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Posts Section --}}
    <div class="mt-10">
        <h3 class="text-2xl font-semibold text-emerald-500 mb-4 border-b border-emerald-400/30 pb-2">🚀 The Ascend Posts</h3>

        @if($user->posts->count())
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
                @foreach($user->posts as $post)
                    <div class="bg-white/10 backdrop-blur-lg border border-emerald-300/30 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-5 flex flex-col">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}"
                                 alt="Post Image"
                                 class="w-full h-52 object-cover rounded-xl border border-emerald-200 shadow-md mb-4">
                        @endif

                        <p class="mb-4 text-sm leading-relaxed whitespace-pre-line">{{ $post->content }}</p>

                        <div class="mt-auto flex justify-between items-center text-xs text-emerald-400">
                            {{-- Likes --}}
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z" />
                                    </svg>
                                    <span>{{ $post->likes->count() }}</span>
                                </div>
                                {{-- Comments --}}
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                    </svg>
                                    <span>{{ $post->comments->count() }}</span>
                                </div>
                            </div>

                            {{-- Timestamp --}}
                            <div class="text-emerald-400 text-xs">{{ $post->created_at->diffForHumans() }}</div>

                            {{-- Delete button --}}
                            @if($user->id === auth()->id())
                                <form action="{{ route('journey.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-lg">
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
            <p class="text-gray-400 mt-6 text-center">There are no posts yet...</p>
        @endif
    </div>
</div>
@endsection