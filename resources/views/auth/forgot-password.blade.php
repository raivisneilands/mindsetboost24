<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="min-h-screen bg-gradient-to-tr from-emerald-600 via-emerald-400 to-emerald-500 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 mx-4">
        <h2 class="text-2xl font-bold text-center text-emerald-700 mb-4">Reset Your Password</h2>

        <p class="text-sm text-gray-700 mb-4 text-center">
            Forgot your password? No problem. Just let us know your email and we’ll send you a password reset link.
        </p>

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-emerald-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-emerald-700 transition">
                    Email Password Reset Link
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-emerald-600 hover:underline">Back to Login</a>
        </div>
    </div>

</body>
</html>
