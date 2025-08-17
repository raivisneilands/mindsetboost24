<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PurchaseController extends Controller
{
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with('products') // eager load products
            ->latest()
            ->get();

        // Flatten all products with their corresponding order
        $allProducts = $orders->flatMap(function ($order) {
            return $order->products->map(function ($product) use ($order) {
                $product->order_date = $order->created_at;
                $product->order_id = $order->id;
                return $product;
            });
        });

        return view('purchases.index', [
            'orders' => $orders,
            'allProducts' => $allProducts,
        ]);
    }
}
