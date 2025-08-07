<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
</head>
<body class="min-h-screen bg-gradient-to-tr from-emerald-600 via-emerald-400 to-emerald-200 flex items-center justify-center">

    <div class="backdrop-blur-xl bg-white/20 border border-white/30 rounded-xl shadow-2xl w-full max-w-md p-8 mx-4 text-white">
        <h2 class="text-3xl font-bold text-center mb-6">Register</h2>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-100/10 border border-red-400 px-4 py-3 text-red-700 relative">
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

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block mb-1 text-white/80 font-bold">Name</label>
                <input id="name" type="text" name="name" required autofocus
                    class="w-full px-4 py-2 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300">
            </div>
                        
            <div>
                <label for="username" class="block mb-1 text-white/80 font-bold">Username</label>
                <input id="username" type="text" name="username" required
                    class="w-full px-4 py-2 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300">
            </div>

            <div>
                <label for="email" class="block mb-1 text-white/80 font-bold">Email</label>
                <input id="email" type="email" name="email" required
                    class="w-full px-4 py-2 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300">
            </div>

            <div>
                <label for="password" class="block mb-1 text-white/80 font-bold">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300">
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 text-white/80 font-bold">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border border-white/30 bg-white/10 text-white placeholder-white/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-300">
            </div>

            <button type="submit"
                class="w-full bg-emerald-500/90 text-white py-2 px-4 rounded-lg font-semibold hover:bg-emerald-600 transition">
                Register
            </button>

            <p class="text-center text-sm text-white/80 mt-4">
                Already have an account?
                <a href="{{ route('login') }}" class="text-emerald-100 hover:underline">Login</a>
            </p>
        </form>
    </div>

</body>
</html>
