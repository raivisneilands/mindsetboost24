@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-12 p-6 bg-white rounded-2xl shadow-xl">
    <h2 class="text-3xl font-bold text-emerald-700 mb-6">{{ $pack->title }}</h2>
    <p class="text-gray-700 mb-4">{{ $pack->description }}</p>
    <p class="text-xl font-semibold text-emerald-600 mb-6">
        {{ display_price($pack->discounted_price) }}
    </p>

    {{-- Payment Form (same as product checkout) --}}
    <form id="payment-form" data-secret="{{ $clientSecret }}">
        <div id="card-element" class="p-4 border border-gray-300 rounded-lg bg-white shadow-sm mb-4"></div>
        <button id="submit" class="w-full py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition">
            Pay Now
        </button>
        <div id="error-message" class="text-red-600 text-sm mt-2"></div>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create("card", {hidePostalCode: true});
    card.mount("#card-element");
    const form = document.getElementById("payment-form");
    const clientSecret = form.dataset.secret;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const {error, paymentIntent} = await stripe.confirmCardPayment(clientSecret, { payment_method: { card }});
        if (!error && paymentIntent.status === "succeeded") {
            window.location.href = "{{ url('/checkout/pack/'.$pack->slug.'/success') }}?payment_intent=" + paymentIntent.id;
        } else if (error) {
            document.getElementById("error-message").textContent = error.message;
        }
    });
</script>
@endsection
