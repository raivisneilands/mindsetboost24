<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="min-h-screen bg-gradient-to-r from-emerald-500 via-lime-500 to-green-500 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 mx-4">
        <h2 class="text-3xl font-bold text-center text-teal-700 mb-6">Login</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block mb-1 text-gray-700">Email</label>
                <input id="email" type="email" name="email" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="password" class="block mb-1 text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-teal-600 hover:underline">Forgot?</a>
            </div>

            <button type="submit"
                class="w-full bg-teal-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-teal-700 transition">
                Login
            </button>

            <p class="text-center text-sm text-gray-600 mt-4">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-teal-600 hover:underline">Register</a>
            </p>
        </form>
    </div>

</body>
</html>
