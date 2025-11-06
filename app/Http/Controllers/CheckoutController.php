<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductPack;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function show(Product $product)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $user = auth()->user();

        // ✅ Already purchased
        $existingOrder = Order::where('user_id', $user->id)
            ->whereHas('orderItems', fn($q) => $q->where('product_id', $product->id))
            ->whereIn('status', ['paid', 'completed'])
            ->first();

        if ($existingOrder) {
            return redirect()->route('purchases.index')
                ->with('message', 'You already own this product.');
        }

        // ✅ Reuse pending order if possible
        $pendingOrder = Order::where('user_id', $user->id)
            ->whereHas('orderItems', fn($q) => $q->where('product_id', $product->id))
            ->where('status', 'pending')
            ->first();

        if ($pendingOrder) {
            $intent = PaymentIntent::retrieve($pendingOrder->stripe_payment_intent_id);

            // If intent already confirmed, create a new one
            if ($intent->status !== 'requires_payment_method' && $intent->status !== 'requires_confirmation') {
                $intent = PaymentIntent::create([
                    'amount' => intval($product->active_price * 100),
                    'currency' => 'eur',
                    'metadata' => [
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'type' => 'product',
                    ],
                ]);

                $pendingOrder->update(['stripe_payment_intent_id' => $intent->id]);
            }
        } else {
            $intent = PaymentIntent::create([
                'amount' => intval($product->active_price * 100),
                'currency' => 'eur',
                'metadata' => [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'type' => 'product',
                ],
            ]);

            $pendingOrder = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total_price' => $product->active_price,
                'stripe_payment_intent_id' => $intent->id,
            ]);

            OrderItem::create([
                'order_id' => $pendingOrder->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->active_price,
            ]);
        }

        return view('checkout.show', [
            'product' => $product,
            'clientSecret' => $intent->client_secret,
            'paymentIntentId' => $intent->id,
        ]);
    }

    public function showPack(ProductPack $pack)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $user = auth()->user();

        // ✅ Skip if user already owns all products
        $alreadyOwned = $pack->products->every(fn($p) =>
            Order::where('user_id', $user->id)
                ->whereHas('orderItems', fn($q) => $q->where('product_id', $p->id))
                ->whereIn('status', ['paid', 'completed'])
                ->exists()
        );

        if ($alreadyOwned) {
            return redirect()->route('purchases.index')
                ->with('message', 'You already own all products in this pack.');
        }

        // Determine the total amount in cents
        $amount = intval(($pack->discounted_price ?? $pack->total_price) * 100);
        
        // Handle free pack (or below Stripe minimum)
        if ($amount < 50) {
            // Check if user already has a completed order for THIS pack
            $pendingOrder = Order::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereHas('orderItems', function($q) use ($pack) {
                    $q->whereIn('product_id', $pack->products->pluck('id'));
                })
                ->first();

            if (!$pendingOrder) {
                // Create a new completed order for this pack
                $pendingOrder = Order::create([
                    'user_id' => $user->id,
                    'status' => 'completed',
                    'total_price' => 0,
                ]);

                foreach ($pack->products as $product) {
                    OrderItem::create([
                        'order_id' => $pendingOrder->id,
                        'product_id' => $product->id,
                        'quantity' => 1,
                        'price' => 0,
                    ]);
                }
            }

            return redirect()->route('purchases.index')
                ->with('message', 'Free pack added to your account!');
        }

        // ✅ Reuse pending order if exists
        $pendingOrder = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->whereHas('orderItems', function ($q) use ($pack) {
                $q->whereIn('product_id', $pack->products->pluck('id'));
            })
            ->first();

        try {
            if ($pendingOrder && $pendingOrder->stripe_payment_intent_id) {
                $intent = PaymentIntent::retrieve($pendingOrder->stripe_payment_intent_id);

                if (!in_array($intent->status, ['requires_payment_method', 'requires_confirmation'])) {
                    // Create new intent if old one is used/cancelled
                    $intent = PaymentIntent::create([
                        'amount' => $amount,
                        'currency' => 'eur',
                        'metadata' => [
                            'user_id' => $user->id,
                            'pack_id' => $pack->id,
                            'type' => 'pack',
                        ],
                    ]);
                    $pendingOrder->update(['stripe_payment_intent_id' => $intent->id]);
                }
            } else {
                // Create new PaymentIntent and pending order
                $intent = PaymentIntent::create([
                    'amount' => $amount,
                    'currency' => 'eur',
                    'metadata' => [
                        'user_id' => $user->id,
                        'pack_id' => $pack->id,
                        'type' => 'pack',
                    ],
                ]);

                $pendingOrder = Order::create([
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'total_price' => $pack->discounted_price ?? $pack->total_price,
                    'stripe_payment_intent_id' => $intent->id,
                ]);

                foreach ($pack->products as $product) {
                    OrderItem::create([
                        'order_id' => $pendingOrder->id,
                        'product_id' => $product->id,
                        'quantity' => 1,
                        'price' => $product->active_price ?? 0,
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Stripe PaymentIntent error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to create payment. Please try again later.');
        }

        return view('checkout.pack', [
            'pack' => $pack,
            'clientSecret' => $intent->client_secret,
            'paymentIntentId' => $intent->id,
        ]);
    }


    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntentId = $request->query('payment_intent');

        if (!$paymentIntentId) {
            abort(400, 'Missing payment_intent');
        }

        $order = Order::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if (!$order) {
            return redirect()->route('purchases.index')
                ->with('message', 'Your payment was successful! Your order will appear shortly.');
        }

        if ($order->status !== 'paid') {
            $order->update(['status' => 'paid']);
        }

        $firstItem = $order->orderItems()->first();
        $type = $firstItem && $order->orderItems()->count() > 1 ? 'pack' : 'product';

        return view('checkout.success', compact('order', 'type'));
    }
}
