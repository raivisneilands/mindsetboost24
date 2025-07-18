<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Create 20 orders
        Order::factory()
            ->count(20)
            ->create()
            ->each(function ($order) {
                $items = collect();

                // Attach 1–3 random products
                for ($i = 0; $i < rand(1, 3); $i++) {
                    $product = \App\Models\Product::inRandomOrder()->first();

                    if ($product) {
                        $items->push(OrderItem::create([
                            'order_id'   => $order->id,
                            'product_id' => $product->id,
                            'quantity'   => rand(1, 3),
                            'price'      => $product->price,
                        ]));
                    }
                }

                // Update total price
                $total = $items->sum(fn($item) => $item->price * $item->quantity);
                $order->update(['total_price' => $total]);
            });
    }
}

