<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use App\Models\Product;
use App\Models\Order;

class GiveWelcomeGift
{
    public function handle(Verified $event)
    {
        $user = $event->user;

        // Find the welcome gift product
        $giftProduct = Product::where('is_welcome_gift', true)->first();

        if (! $giftProduct) {
            return; // no gift product set, exit
        }

        // Check if user already has this gift
        $hasGift = $user->orders()
            ->whereHas('orderItems', function ($query) use ($giftProduct) {
                $query->where('product_id', $giftProduct->id);
            })->exists();

        if ($hasGift) {
            return; // user already has it, exit
        }

        // Create order with gift
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'welcome gift',
            'total_price' => 0,
        ]);

        $order->orderItems()->create([
            'product_id' => $giftProduct->id,
            'quantity' => 1,
            'price' => 0,
        ]);

        session()->flash('gift', '🎉 Your free welcome gift is waiting in your <a href="' . route('purchases.index') . '" class="underline font-semibold text-white">purchases</a>!');

    }
}
