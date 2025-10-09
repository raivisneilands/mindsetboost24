<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        Log::info('Stripe webhook hit', ['payload' => $payload]);

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload');
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature');
            return response('Invalid signature', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;

            $userId = $intent->metadata->user_id ?? null;
            $productId = $intent->metadata->product_id ?? null;

            if (!$userId || !$productId) {
                Log::error('Missing user_id or product_id in metadata', ['metadata' => $intent->metadata ?? null]);
                return response('Missing metadata', 400);
            }

            $user = User::find($userId);
            $product = Product::find($productId);

            if (!$user || !$product) {
                Log::error('User or Product not found', ['user_id' => $userId, 'product_id' => $productId]);
                return response('User or product not found', 404);
            }

            // Prevent duplicates
            $existing = Order::where('stripe_session_id', $intent->id)->first();
            if ($existing) {
                Log::info('Order already exists, skipping creation.', ['order_id' => $existing->id]);
                return response('Order already exists', 200);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'stripe_session_id' => $intent->id, // reusing this field
                'total_price' => $product->price,
                'status' => 'Completed',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => 1,
            ]);

            Mail::to($user->email)->send(new OrderConfirmation($order, $product));

            Log::info('Order created successfully via PaymentIntent', ['order_id' => $order->id]);
        }

        return response('Webhook handled', 200);
    }
}
