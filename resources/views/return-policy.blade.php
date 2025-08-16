@extends('layouts.app')

@section('title', 'Return & Refund Policy')

@section('content')
<div class="bg-emerald-50 py-20">
    <div class="container mx-auto px-6 max-w-3xl bg-white rounded-2xl shadow-lg p-10">
        <h1 class="text-3xl font-extrabold text-emerald-800 mb-6">Return & Refund Policy</h1>

        <p class="text-gray-700 mb-6">
            At <span class="font-semibold">Mindset Boost 24</span>, we provide <strong>digital products</strong> 
            such as challenges, journals, guides and frameworks. Because these items are 
            delivered instantly and cannot be returned, <strong>all sales are final</strong>.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">No Refunds for Digital Products</h2>
        <p class="text-gray-700 mb-6">
            Once your purchase is completed and the product is delivered, we cannot offer 
            refunds, exchanges, or cancellations. Please review product descriptions carefully 
            before making your purchase.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">Accidental Purchases</h2>
        <p class="text-gray-700 mb-6">
            If you believe you purchased by mistake or encountered a technical issue during 
            checkout, please contact <span class="font-bold italic text-emerald-600">support@mindsetboost24.com</span></a> 
            within 24 hours. While refunds are not guaranteed, we will review your case to ensure 
            fairness.
        </p>

        <h2 class="text-xl font-bold text-emerald-700 mt-8 mb-3">Customer Support</h2>
        <p class="text-gray-700 mb-6">
            If you experience any issues with accessing your digital files, please reach out to 
            our support team at <span class="font-bold italic text-emerald-600">
            support@mindsetboost24.com</span>. We will make sure you get the product you paid for.
        </p>

        <p class="text-sm text-gray-500 mt-12">
            Last updated: {{ now()->format('F j, Y') }}
        </p>
    </div>
</div>
@endsection
