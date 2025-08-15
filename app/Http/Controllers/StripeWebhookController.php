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

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload');
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature');
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            Log::info('Webhook received', [
                'type' => $event->type,
                'metadata' => $session->metadata ?? null,
                'session_id' => $session->id,
            ]);

            $userId = $session->metadata->user_id ?? null;
            $productId = $session->metadata->product_id ?? null;

            if (!$userId || !$productId) {
                Log::error('Missing user_id or product_id in metadata', ['metadata' => $session->metadata ?? null]);
                return response('Missing metadata', 400);
            }

            $user = User::find($userId);
            $product = Product::find($productId);

            if (!$user || !$product) {
                Log::error('User or Product not found', [
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);
                return response('User or product not found', 404);
            }

            // Check if order already exists
            $existing = Order::where('stripe_session_id', $session->id)->first();
            if ($existing) {
                Log::info('Order already exists, skipping creation.', ['order_id' => $existing->id]);
                return response('Order already exists', 200);
            }

            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'stripe_session_id' => $session->id,
                'total_price' => $product->price,
                'status' => 'Completed',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => 1,
            ]);

            Log::info('Order created successfully', ['order_id' => $order->id]);
        }

        return response('Webhook handled', 200);
    }
}
