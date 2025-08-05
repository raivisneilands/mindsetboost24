@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white shadow-md border border-emerald-200 rounded-lg p-6 text-center">
    <!-- Profile Image -->
    @if($user->profile_image)
        <img src="{{ asset('storage/' . $user->profile_image) }}"
             alt="{{ $user->username }}'s Profile"
             class="w-28 h-28 rounded-full object-cover mx-auto border-4 border-emerald-300 shadow mb-4">
    @else
        <div class="w-28 h-28 mx-auto flex items-center justify-center rounded-full bg-white border-4 border-emerald-300 shadow mb-4">
            <svg class="w-12 h-12 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4zm0-2a4 4 0 110-8 4 4 0 010 8z"/>
            </svg>
        </div>
    @endif

    <!-- Username -->
    <h2 class="text-2xl font-bold text-emerald-700 mb-2">{{ $user->username }}</h2>

    <!-- Bio -->
    @if($user->bio)
        <p class="text-gray-700 italic mb-4 trix-content">{{ $user->bio }}</p>
    @else
        <p class="text-gray-400 italic mb-4">No bio provided yet.</p>
    @endif

    <!-- Edit Profile Button -->
    @auth
        @if(auth()->id() === $user->id)
            <a href="{{ route('profile.edit') }}"
               class="inline-block mt-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded hover:bg-emerald-700 transition">
                Edit Profile
            </a>
        @endif
    @endauth
</div>
@endsection
