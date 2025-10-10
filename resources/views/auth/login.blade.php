<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>

<body class="min-h-screen bg-gradient-to-tr from-emerald-600 via-emerald-400 to-emerald-500 flex items-center justify-center relative overflow-hidden">

    {{-- Decorative subtle glow --}}
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,rgba(255,255,255,0.2),transparent_60%)]"></div>

    {{-- Floating motivational quote --}}
    <div class="absolute top-8 text-center w-full text-white/80 text-sm tracking-wide animate-pulse">
        “Discipline begins the moment you decide to act.”
    </div>

    <div class="relative backdrop-blur-2xl bg-white/15 border border-white/20 rounded-2xl shadow-2xl w-full max-w-md p-10 mx-4 text-white">

        {{-- Logo --}}
        <div class="flex justify-center mb-4">
            <img src="{{ asset('favicon.png') }}" alt="Mindset Boost 24 Logo" class="h-10 opacity-90">
        </div>

        {{-- Headline --}}
        <h2 class="text-3xl font-extrabold text-center mb-2 drop-shadow-sm">Welcome Back</h2>
        <p class="text-center text-white/80 text-sm mb-6">
            Log in to continue your <span class="text-emerald-200 font-semibold">Mindset Mastery</span> journey.
        </p>

        {{-- Error messages --}}
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-100 border border-red-400 px-4 py-3 text-red-700 relative">
                <button class="absolute top-2 right-3 text-red-500 hover:text-red-700" onclick="this.parentElement.remove();">
                    &times;
                </button>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Login form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block mb-1 text-white/80 font-medium">Email</label>
                <input id="email" type="email" name="email" required autofocus
                    class="w-full px-4 py-2 border border-white/30 bg-white/10 text-white placeholder-white/60 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300">
            </div>

            <div>
                <label for="password" class="block mb-1 text-white/80 font-medium">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border border-white/30 bg-white/10 text-white placeholder-white/60 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300">
            </div>

            <div class="flex items-center justify-between text-sm">
                <a href="{{ route('password.request') }}" class="text-emerald-100 hover:underline">Forgot password?</a>
            </div>

            <button type="submit"
                class="w-full bg-emerald-500/90 text-white py-3 px-4 rounded-lg font-semibold hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-400/30 transition-all duration-300">
                Log In
            </button>

            <p class="text-center text-sm text-white/80 mt-4">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-emerald-100 hover:underline">Join the movement</a>
            </p>
        </form>
    </div>
</body>
</html>
