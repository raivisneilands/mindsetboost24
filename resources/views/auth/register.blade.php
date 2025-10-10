<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 flex items-center justify-center font-sans">

    <div class="relative w-full max-w-md p-8 mx-4 text-white backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl shadow-[0_0_40px_rgba(0,0,0,0.3)] animate-[fadeUp_0.6s_ease-out]">
        
        <!-- Logo / Branding -->
        <div class="absolute -top-12 left-1/2 -translate-x-1/2 bg-white/20 backdrop-blur-lg border border-white/30 rounded-full p-4 shadow-lg">
            <img src="{{ asset('favicon.png') }}" alt="Mindset Boost 24" class="w-10 h-10">
        </div>

        <h2 class="text-3xl font-bold text-center mb-2 mt-4">Join the Ascent</h2>
        <p class="text-center text-white/70 mb-6 text-sm">Create your account and begin your growth journey.</p>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-100/10 border border-red-400 px-4 py-3 text-red-200 relative">
                <button class="absolute top-2 right-3 text-red-300 hover:text-red-500" onclick="this.parentElement.remove();">
                    &times;
                </button>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block mb-1 text-white/80 font-semibold">Full Name</label>
                    <input id="name" type="text" name="name" required autofocus
                        class="w-full px-4 py-2.5 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300 transition">
                </div>
                
                <div>
                    <label for="username" class="block mb-1 text-white/80 font-semibold">Username</label>
                    <input id="username" type="text" name="username" required
                        class="w-full px-4 py-2.5 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300 transition">
                </div>
            </div>
            <div>
                <label for="email" class="block mb-1 text-white/80 font-semibold">Email</label>
                <input id="email" type="email" name="email" required
                    class="w-full px-4 py-2.5 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300 transition">
            </div>

                <div>
                    <label for="password" class="block mb-1 text-white/80 font-semibold">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2.5 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300 transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-1 text-white/80 font-semibold">Confirm</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-2.5 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300 transition">
                </div>

            <button type="submit"
                class="w-full mt-2 bg-emerald-500/90 text-white py-2.5 px-4 rounded-lg font-semibold hover:bg-emerald-600 transition shadow-lg hover:shadow-emerald-800/20">
                Create Account
            </button>

            <p class="text-center text-sm text-white/70 mt-4">
                Already part of the journey? 
                <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">Login</a>
            </p>
        </form>

        <p class="text-center text-xs text-white/50 mt-6">By joining, you agree to our <a href="{{ route('terms') }}" class="underline hover:text-white">terms</a>.</p>
    </div>

</body>
</html>
