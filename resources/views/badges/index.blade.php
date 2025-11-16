@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-16">

    <h1 class="text-3xl font-bold mb-8 text-emerald-700">Badges</h1>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

        @php
            // Sort badges: unlocked first, locked later
            $badges = $badges->sortByDesc(function($badge) use ($unlocked) {
                return in_array($badge->id, $unlocked) ? 1 : 0;
            });
        @endphp

        @foreach($badges as $badge)
            @php
                $isUnlocked = in_array($badge->id, $unlocked);
            @endphp

            <div class="relative p-4 rounded-xl border 
                {{ $isUnlocked ? 'border-emerald-400 bg-emerald-900/90' : 'border-emerald-700 bg-emerald-800/70 opacity-60' }} 
                flex flex-col items-center text-center shadow-lg"
            >

                {{-- Locked badge overlay --}}
                @unless($isUnlocked)
                    <div class="absolute inset-0 bg-black/50 rounded-xl flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white opacity-70" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 15v2"></path>
                            <path d="M12 11a1 1 0 0 1 1 1v4a1 1 0 0 1-2 0v-4a1 1 0 0 1 1-1z"></path>
                            <path d="M8 11V7a4 4 0 1 1 8 0v4"></path>
                        </svg>
                    </div>
                @endunless

                <div class="text-5xl mb-2">{{ $badge->icon }}</div>

                <h3 class="text-lg font-semibold text-white">
                    {{ $badge->name }}
                </h3>

                <p class="text-sm text-emerald-200 mt-1">
                    {{ $badge->description }}
                </p>

            </div>
        @endforeach
    </div>

</div>
@endsection
