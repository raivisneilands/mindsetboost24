<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductPageController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'published')
            ->with('categories')
            ->latest()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'published')
            ->with('categories')
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}

