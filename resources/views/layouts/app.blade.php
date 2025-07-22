<!-- layout/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('meta')
</head>
<body class="bg-white text-gray-800 antialiased">
    @if(auth()->check() && auth()->user()->is_admin)
        @include('components.admin-navigation')
    @else
        @if (!Request::is('/'))
            @include('components.navigation')
        @endif
    @endif
    @yield('content')
    <!-- Include Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
