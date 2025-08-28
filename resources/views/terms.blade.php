@extends('layouts.app')

@section('title', 'Terms of Service | Mindset Boost 24')
@section('meta_description', 'Review the terms of service for using Mindset Boost 24 and our digital products.')

@section('content')
<div class="bg-emerald-50 py-20">
    <div class="container mx-auto px-6 max-w-3xl bg-white rounded-2xl shadow-lg p-10">
        <h1 class="text-3xl font-extrabold text-emerald-800 mb-6">Terms of Service</h1>

        <p class="text-gray-700 mb-6">
            By using <span class="font-semibold">Mindset Boost 24</span>, you agree to the following terms and conditions.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">1. Digital Products</h2>
        <p class="text-gray-700 mb-6">
            All products sold on our site are digital. Once delivered, they are considered 
            consumed and non-returnable, as outlined in our 
            <a href="{{ route('return.policy') }}" class="text-emerald-600 hover:underline">Return Policy</a>.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">2. Payment</h2>
        <p class="text-gray-700 mb-6">
            Payments are securely processed by Stripe. By purchasing, you authorize us to charge 
            your selected payment method for the total order amount.
        </p>
        <p class="text-gray-700 mb-6">
            <span class="font-semibold">Currency Disclaimer:</span> All payments are processed in 
            <span class="font-semibold">EUR (Euros)</span>. Prices displayed in other currencies 
            (such as USD or GBP) are approximate conversions for your convenience. Your bank may 
            apply a currency conversion fee and the final charge on your statement may differ 
            slightly from the displayed estimate.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">3. License of Use</h2>
        <p class="text-gray-700 mb-6">
            Your purchase grants you a personal, non-transferable license to use the product. 
            Reselling, sharing, or distributing our digital products is prohibited.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">4. Limitation of Liability</h2>
        <p class="text-gray-700 mb-6">
            Our products are intended for educational and personal development purposes. We do not 
            guarantee specific results, and we are not liable for any damages arising from use of 
            our materials.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">5. Contact</h2>
        <p class="text-gray-700 mb-6">
            If you have questions about these terms, contact us at 
            <span class="text-emerald-600 font-bold italic">
                support@mindsetboost24.com
            </span>.
        </p>

        <p class="text-sm text-gray-500 mt-12">
            Last updated: {{ now()->format('F j, Y') }}
        </p>
    </div>
</div>
@endsection
