<!-- layout/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MND8WHRQNG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-MND8WHRQNG');
    </script>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')

    {{-- Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    {{-- AOS (Animate On Scroll) CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
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
    [x-cloak] { display: none !important; }
        .alien-glow {
        background: linear-gradient(135deg, rgba(0,255,255,0.1), rgba(180,0,255,0.1));
        backdrop-filter: blur(6px);
        border: 1px solid rgba(0,255,255,0.2);
        box-shadow: 0 0 20px rgba(0,255,255,0.2);
    }
    .alien-font {
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 0.05em;
    }
</style>
<body class="bg-white text-gray-800 antialiased {{ !Request::is('/') ? 'pt-16' : '' }}">
    @if (!Request::is('/'))
        @include('components.navigation')
        @if(auth()->check() && auth()->user()->is_admin)
            @include('components.admin-navigation')
        @endif
    @endif
    @yield('content')
    <!-- Include Alpine.js -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
