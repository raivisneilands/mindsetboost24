<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function show(Product $product)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => intval($product->active_price * 100),
            'currency' => 'eur',
            'metadata' => [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
        ]);

        // Create a pending order right away
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => $product->active_price,
            'stripe_payment_intent_id' => $intent->id,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->active_price,
        ]);

        return view('checkout.show', [
            'product' => $product,
            'clientSecret' => $intent->client_secret,
            'paymentIntentId' => $intent->id,
        ]);
    }

    public function success(Request $request, Product $product)
    {
        $paymentIntentId = $request->query('payment_intent');

        if (!$paymentIntentId) {
            abort(400, 'Missing payment_intent');
        }

        $order = Order::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if (!$order) {
            abort(404, 'Order not found');
        }

        // Mark order as paid
        $order->update(['status' => 'paid']);

        return view('checkout.success', compact('order', 'product'));
    }
}
