<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;

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
            'metadata' => [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
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
            'success_url' => url("/checkout/{$product->slug}/success") . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.show', $product->slug),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            abort(400, 'Missing session_id');
        }

        $order = Order::where('stripe_session_id', $sessionId)->first();
        if (!$order) {
            abort(404, 'Order not found');
        }

        return view('checkout.success', compact('product', 'order'));
    }

}
