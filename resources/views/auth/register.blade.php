<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="min-h-screen bg-gradient-to-r from-emerald-500 via-lime-500 to-green-500 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 mx-4">
        <h2 class="text-3xl font-bold text-center text-teal-700 mb-6">Register</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block mb-1 text-gray-700">Name</label>
                <input id="name" type="text" name="name" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="email" class="block mb-1 text-gray-700">Email</label>
                <input id="email" type="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="password" class="block mb-1 text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 text-gray-700">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <button type="submit"
                class="w-full bg-teal-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Register
            </button>

            <p class="text-center text-sm text-gray-600 mt-4">
                Already have an account?
                <a href="{{ route('login') }}" class="text-teal-600 hover:underline">Login</a>
            </p>
        </form>
    </div>

</body>
</html>
