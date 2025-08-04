<!-- layout/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('meta')

    {{-- Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    
</head>
<style>
    /* Hide attachment button */
    trix-toolbar [data-trix-action="attachFiles"] {
        display: none !important;
        }

        /* Mobile & tablets: multi-row and bigger buttons */
        @media (max-width: 768px) {
        .trix-button-row {
            white-space: normal !important;
            flex-wrap: wrap !important;
        }

        .trix-button {
            padding: 0.6rem 1rem !important;
            font-size: 1.25rem !important;
            margin: 0.25rem !important;
        }

        .trix-toolbar {
            padding: 0.75rem 1rem !important;
            height: auto !important;
        }
    }
</style>
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
