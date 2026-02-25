<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 flex items-center justify-center px-4 sm:px-6">

    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(255,255,255,0.2),transparent_60%)] animate-pulse-slow"></div>

    <div class="relative w-full max-w-sm sm:max-w-md bg-white/20 backdrop-blur-3xl border border-white/20 rounded-3xl shadow-lg p-5 sm:p-8 flex flex-col justify-center h-[90vh]">

        {{-- Logo --}}
        <div class="mb-2 flex justify-center">
            <img src="{{ asset('favicon.png') }}" alt="Mindset Boost 24" class="w-10 h-10">
        </div>

        <h2 class="text-2xl font-bold text-center text-white mb-1">Join the Ascent</h2>
        <p class="text-center text-white/70 mb-4 text-sm sm:text-base">Create your account and begin your growth journey.</p>

        {{-- Error messages --}}
        @if ($errors->any())
            <div class="mb-3 rounded-md bg-red-100/20 border border-red-400 px-3 py-2 text-red-200 w-full text-sm overflow-auto max-h-20">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-3 w-full sm:w-[90%] flex-1 overflow-auto">
            @csrf

            {{-- Name + Username --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <input type="text" name="name" placeholder="Full Name" required
                       class="w-full px-3 py-2 rounded-lg border border-white/30 bg-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition text-sm">
                <input type="text" name="username" placeholder="Username" required
                       class="w-full px-3 py-2 rounded-lg border border-white/30 bg-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition text-sm">
            </div>

            {{-- Email --}}
            <input type="email" name="email" placeholder="Email" required
                   class="w-full px-3 py-2 rounded-lg border border-white/30 bg-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition text-sm">

            {{-- Password + Confirm --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <input type="password" name="password" placeholder="Password" required
                       class="w-full px-3 py-2 rounded-lg border border-white/30 bg-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition text-sm">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                       class="w-full px-3 py-2 rounded-lg border border-white/30 bg-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition text-sm">
            </div>

            {{-- Submit --}}
            <button type="submit" class="w-full bg-emerald-500 text-white py-2 rounded-lg font-semibold hover:bg-emerald-600 transition text-sm">
                Create Account
            </button>

            {{-- Login link --}}
            <p class="text-center text-sm text-white/80 mt-2">
                Already part of the journey? 
                <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">Login</a>
            </p>
        </form>

        <p class="text-center text-xs text-white/50 mt-3">By joining, you agree to our <a href="{{ route('terms') }}" class="underline hover:text-white">terms</a>.</p>
    </div>
</body>

</html>
