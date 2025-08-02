<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::withCount('orderItems') // For purchase count
                    ->withAvg('reviews', 'rating'); // For average rating

        // Filter by category if selected
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Search by keyword
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'rating':
                    $query->orderByDesc('reviews_avg_rating');
                    break;
                case 'purchases':
                    $query->orderByDesc('order_items_count');
                    break;
                case 'price_low_high':
                    $query->orderBy('price');
                    break;
                case 'price_high_low':
                    $query->orderByDesc('price');
                    break;
            }
        } else {
            $query->latest(); // default sort
        }

        $products = $query->paginate(12)->withQueryString(); // <– this preserves filters when paginating
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
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

