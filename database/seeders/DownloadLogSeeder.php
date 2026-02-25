<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DownloadLog;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DownloadLogSeeder extends Seeder
{
    public function run(): void
    {
        // Only consider orders with completed status
        $completedOrderItems = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'completed');
        })->get();

        if ($completedOrderItems->isEmpty()) {
            $this->command->info("No completed orders found. Seed some orders first.");
            return;
        }

        foreach ($completedOrderItems as $item) {
            // Random chance the user downloaded the product
            if (rand(0, 1)) { // 50% chance
                DownloadLog::create([
                    'user_id' => $item->order->user_id,
                    'order_id' => $item->order_id,
                    'product_id' => $item->product_id,
                    'ip_address' => '127.0.' . rand(0, 255) . '.' . rand(1, 254),
                ]);
            }
        }

        $this->command->info("Download logs seeded successfully.");
    }
}