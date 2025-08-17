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
    <meta name="p:domain_verify" content="2ba039dbb7916a34ad3f6064fbdabcba"/>
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
<body class="bg-emerald-50 text-gray-800 antialiased min-h-screen flex flex-col {{ !Request::is('/') ? 'pt-16' : '' }}">
    @include('components.navigation')
    @if(auth()->check() && auth()->user()->is_admin)
        @include('components.admin-navigation')
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-emerald-800 text-white py-8 mt-16">
        <div class="container mx-auto px-6 flex flex-col sm:flex-row justify-between items-center text-sm">
            <p>&copy; {{ date('Y') }} Mindset Boost 24. All rights reserved.</p>
            <div class="flex gap-6 mt-4 sm:mt-0">
                <a href="{{ route('return.policy') }}" class="hover:underline">Return Policy</a>
                <a href="{{ route('privacy.policy') }}" class="hover:underline">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="hover:underline">Terms of Service</a>
            </div>
        </div>
    </footer>

    <!-- Include Alpine.js -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Cookie Consent Banner -->
    <div id="cookie-consent-banner" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-emerald-100 border border-emerald-300 rounded-lg p-4 shadow-lg max-w-xl w-full z-50 hidden">
        <p class="text-gray-700 text-sm">
            We use cookies to improve your experience and analyze site traffic. 
            <span class="font-semibold">You can accept all cookies or manage your preferences.</span>
        </p>
        <div class="mt-2 flex justify-end gap-2">
            <button id="accept-cookies" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                Accept
            </button>
            <button id="decline-cookies" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Decline
            </button>
        </div>
    </div>

    <script>
        // Check if user already made a choice
        if (!localStorage.getItem('cookiesAccepted')) {
            document.getElementById('cookie-consent-banner').style.display = 'block';
        }

        document.getElementById('accept-cookies').addEventListener('click', function() {
            localStorage.setItem('cookiesAccepted', 'true');
            document.getElementById('cookie-consent-banner').style.display = 'none';
            loadGoogleAnalytics();
        });

        document.getElementById('decline-cookies').addEventListener('click', function() {
            localStorage.setItem('cookiesAccepted', 'false');
            document.getElementById('cookie-consent-banner').style.display = 'none';
        });

        function loadGoogleAnalytics() {
            // Replace GA_MEASUREMENT_ID with your Google Analytics ID
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'GA_MEASUREMENT_ID', { 'anonymize_ip': true });

            var gaScript = document.createElement('script');
            gaScript.src = "https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID";
            gaScript.async = true;
            document.head.appendChild(gaScript);
        }

        // Load GA automatically if previously accepted
        if (localStorage.getItem('cookiesAccepted') === 'true') {
            loadGoogleAnalytics();
        }
    </script>

</body>
</html>
