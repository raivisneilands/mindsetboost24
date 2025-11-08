<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = Product::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $freeProducts = Product::where('price', 0)
            ->where('status', 'published')
            ->latest()
            ->paginate(3, ['*'], 'free_page');

        $userCount = User::count();

        $featuredProduct = Product::withCount('orderItems')
            ->where('status', 'published')
            ->orderByDesc('order_items_count')
            ->first();

    $topDownloads = Cache::remember('top_downloads', 300, function () {
        // Step 1: Get top downloaded product IDs
        $popular = DB::table('download_logs')
            ->select('product_id', DB::raw('COUNT(*) as total_downloads'))
            ->groupBy('product_id')
            ->orderByDesc('total_downloads')
            ->limit(10) // grab more in case some are drafts
            ->get();

        $productIds = $popular->pluck('product_id');

        // Step 2: Get only published products
        $products = Product::whereIn('id', $productIds)
            ->where('status', 'published')
            ->get();

        // Step 3: Sort by download count
        $products = $products->sortByDesc(fn($product) => 
            $popular->firstWhere('product_id', $product->id)->total_downloads
        );

        // Step 4: Limit to 4 products (skip drafts automatically)
        return $products->take(3);
    });

        return view('welcome', compact('latestProducts', 'userCount', 'featuredProduct', 'freeProducts', 'topDownloads'));
    }
}
