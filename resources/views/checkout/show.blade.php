@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-12 p-6 bg-white rounded-2xl shadow-xl relative">
    <div class="md:flex md:space-x-8">
        {{-- Product Summary --}}
        <div class="md:w-1/2 space-y-4">
            @if($product->cover_image)
                <img src="{{ asset('storage/' . $product->cover_image) }}" 
                     alt="{{ $product->title }}" 
                     class="w-full h-64 object-cover rounded-xl shadow-md">
            @endif
            <h2 class="text-3xl font-bold text-emerald-700">{{ $product->title }}</h2>
            <p class="text-xl text-gray-800 font-semibold">
                Price: <span class="text-emerald-600">{{ display_price($product->price) }}</span>
            </p>
            <p class="text-gray-600 text-sm leading-relaxed">
                Lifetime access. Instant digital delivery. Refunds are not available.
            </p>
        </div>

        {{-- Payment Form --}}
        <div class="md:w-1/2 mt-6 md:mt-0 p-6 bg-gray-50 rounded-2xl shadow-inner">
            <h3 class="text-2xl font-semibold mb-6 text-gray-700">Secure Payment</h3>

            <form id="payment-form" data-secret="{{ $clientSecret }}" class="space-y-4 relative">
                <div class="mb-4">
                    <label for="card-element" class="block text-gray-700 font-medium mb-2">Card Details</label>
                    <div id="card-element" class="p-4 border border-gray-300 rounded-lg bg-white shadow-sm"></div>
                </div>

                <button id="submit" type="submit" 
                    class="w-full py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition shadow-lg transform hover:scale-105">
                    Pay Now
                </button>

                <div id="error-message" class="text-red-600 text-sm mt-2"></div>
            </form>

            <div class="mt-6 text-gray-500 text-xs space-y-1">
                <p>All payments are processed securely via Stripe.</p>
                <p>Price shown in EUR. Your bank may apply a minor conversion fee if using another currency.</p>
            </div>
        </div>
    </div>

    {{-- Processing Overlay --}}
    <div id="processing-overlay" class="hidden absolute inset-0 bg-black/50 backdrop-blur-sm flex flex-col justify-center items-center rounded-2xl z-50">
        <svg class="animate-spin h-12 w-12 text-white mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <p class="text-white text-lg font-semibold">Processing your payment...</p>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();

    const style = {
        base: {
            color: "#374151",
            fontFamily: 'Inter, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": { color: "#9ca3af" }
        },
        invalid: { color: "#f87171", iconColor: "#f87171" }
    };

    const card = elements.create("card", { style, hidePostalCode: true });
    card.mount("#card-element");

    const form = document.getElementById("payment-form");
    const clientSecret = form.dataset.secret;
    const overlay = document.getElementById("processing-overlay");
    const errorMessage = document.getElementById("error-message");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        errorMessage.textContent = "";

        // Show processing overlay
        overlay.classList.remove("hidden");

        const {error, paymentIntent} = await stripe.confirmCardPayment(clientSecret, {
            payment_method: { card }
        });

        if (error) {
            overlay.classList.add("hidden");
            errorMessage.textContent = error.message;
        } else if (paymentIntent.status === "succeeded") {
            window.location.href = "{{ url('/checkout/'.$product->slug.'/success') }}?payment_intent=" + paymentIntent.id;
        }
    });
</script>
@endsection
