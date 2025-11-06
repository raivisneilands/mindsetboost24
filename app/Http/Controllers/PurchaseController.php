<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PurchaseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ✅ Get all relevant orders, including free packs
        $orders = $user->orders()
            ->with(['products' => function ($q) {
                $q->select('products.id', 'title', 'slug');
            }])
            ->whereIn('status', ['paid', 'completed', 'welcome gift', 'free'])
            ->latest()
            ->get();

        // ✅ Remove duplicate products across orders (keep most recent order)
        $seenProducts = [];
        foreach ($orders as $order) {
            $order->products = $order->products->filter(function ($product) use (&$seenProducts) {
                if (in_array($product->id, $seenProducts)) {
                    return false;
                }
                $seenProducts[] = $product->id;
                return true;
            });
        }

        return view('purchases.index', compact('orders'));
    }

}
