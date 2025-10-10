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

        $user = auth()->user();

        // ✅ Check if this user already bought this product
        $existingOrder = Order::where('user_id', $user->id)
            ->whereHas('orderItems', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->whereIn('status', ['paid', 'completed'])
            ->first();

        if ($existingOrder) {
            return redirect()->route('purchases.index')
                ->with('message', 'You already own this product.');
        }

        // ✅ Create a PaymentIntent
        $intent = PaymentIntent::create([
            'amount' => intval($product->active_price * 100),
            'currency' => 'eur',
            'metadata' => [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
        ]);

        // ✅ Create a pending order right away
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => $product->active_price,
            'stripe_payment_intent_id' => $intent->id,
        ]);

        // ✅ Attach product through OrderItem
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
            // Webhook may not have processed yet
            return redirect()->route('purchases.index')
                ->with('message', 'Your payment was successful! Your order will appear shortly.');
        }

        // If order exists but wasn’t updated yet
        if ($order->status !== 'paid') {
            $order->update(['status' => 'paid']);
        }

        return view('checkout.success', compact('order', 'product'));
    }
}
