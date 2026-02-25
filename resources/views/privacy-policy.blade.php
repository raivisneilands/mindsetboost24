@extends('layouts.app')

@section('title', 'Privacy Policy | Mindset Boost 24')
@section('meta_description', 'Read the Mindset Boost 24 Privacy Policy to learn how we protect your data and respect your privacy.')

@section('content')
<div class="bg-emerald-50 py-20 px-5">
    <div class="container mx-auto px-6 max-w-3xl bg-white rounded-2xl shadow-lg p-10">
        <h1 class="text-3xl font-extrabold text-emerald-800 mb-6">Privacy Policy</h1>

        <p class="text-gray-700 mb-6">
            At <span class="font-semibold">Mindset Boost 24</span>, your privacy is very important to us. 
            This Privacy Policy explains how we collect, use, and protect your information when you use our website.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">Information We Collect</h2>
        <ul class="list-disc list-inside text-gray-700 mb-6">
            <li>Personal details you provide at checkout (such as name and email).</li>
            <li>Payment information handled securely by Stripe (we never store card details).</li>
            <li>IP addresses, collected automatically when you visit our site. These are used for security, fraud prevention, monitoring system performance, and ensuring secure delivery of digital products.</li>
            <li>Basic usage data such as browser type and pages visited, which help us improve the website experience.</li>
            <li>Cookies from third-party services like Google Analytics, which are used to analyze website traffic and improve user experience. Cookies are only set after you provide consent.</li>
        </ul>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">How We Use Your Information</h2>
        <p class="text-gray-700 mb-6">
            We use your information to process orders, deliver digital products, and improve our services. 
            IP addresses are specifically used to maintain site security, prevent fraudulent activity, and ensure proper product delivery. 
            Analytics cookies, such as those from Google Analytics, help us understand how visitors interact with our site and improve its functionality. 
            We never sell or share your personal data with third parties.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">Cookies</h2>
        <p class="text-gray-700 mb-6">
            Our website uses cookies to enhance your browsing experience. Essential cookies are always active, while analytics and tracking cookies (like Google Analytics) are only used after you provide consent through the cookie banner. 
            You can manage or disable cookies in your browser settings at any time.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">Your Rights</h2>
        <p class="text-gray-700 mb-6">
            Under GDPR (for EU/EEA residents), you have the right to access, correct, or delete your personal data, restrict or object to processing, and request data portability. 
            Under CCPA (for California residents), you have the right to know what personal information we collect, request deletion, and opt-out of the sale of personal information. 
            Mindset Boost 24 does not sell your personal information. 
            To exercise your rights, contact us at 
            <span class="font-bold italic text-emerald-600">support@mindsetboost24.com</span>.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">Age Restriction</h2>
        <p class="text-gray-700 mb-6">
            By using Mindset Boost 24, you confirm that you are at least <span class="font-semibold">15 years old</span>. 
            If you are under 15, you may not create an account, purchase products, or use our services without parental or guardian consent.
        </p>

        <p class="text-sm text-gray-500 mt-12">
            Last updated: {{ now()->format('F j, Y') }}
        </p>
    </div>
</div>
@endsection
