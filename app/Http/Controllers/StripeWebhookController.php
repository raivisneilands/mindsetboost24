<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\User;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook signature verification failed.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            \Log::info('Webhook received', ['session_id' => $session->id]);

            $existingOrder = Order::where('stripe_session_id', $session->id)->first();

            if ($existingOrder) {
                Log::info('Order already exists', ['order_id' => $existingOrder->id]);
            } else {
                $user = User::find($session->metadata->user_id ?? null);
                $product = Product::find($session->metadata->product_id ?? null);

                if (!$user) {
                    Log::error('User not found from session metadata', ['metadata' => $session->metadata]);
                }
                if (!$product) {
                    Log::error('Product not found from session metadata', ['metadata' => $session->metadata]);
                }

                if ($user && $product) {
                    $order = Order::create([
                        'user_id' => $user->id,
                        'stripe_session_id' => $session->id,
                        'status' => 'completed',
                        'total_price' => $session->amount_total / 100,
                    ]);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => 1,
                        'price' => $product->price,
                    ]);

                    Log::info('Order created successfully', ['order_id' => $order->id]);

                    // Mail::to($user->email)->send(new OrderConfirmation($order, $product));
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}

