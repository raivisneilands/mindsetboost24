<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function show(Product $product)
    {
        return view('checkout.show', compact('product'));
    }

    public function process(Request $request, Product $product)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',  // or your currency
                    'product_data' => [
                        'name' => $product->title,
                    ],
                    'unit_amount' => intval($product->price * 100), // amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['product' => $product->slug]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.show', $product->slug),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request, Product $product)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            abort(400, 'Missing session_id');
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            // Check if order already created for this session to avoid duplicates (optional)
            $existingOrder = Order::where('stripe_session_id', $sessionId)->first();
            if (!$existingOrder) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'status' => 'completed',
                    'total_price' => $session->amount_total / 100, // Stripe amounts are in cents
                    'stripe_session_id' => $sessionId, // add this column to orders table!
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ]);
            } else {
                $order = $existingOrder;
            }

            return view('checkout.success', compact('product', 'order'));
        }

        abort(404);
    }

}
