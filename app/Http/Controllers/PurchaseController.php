<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class PurchaseController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('products')->latest()->get();

        return view('purchases.index', compact('orders'));
    }
}
