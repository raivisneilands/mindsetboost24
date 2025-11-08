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
            $popular = DB::table('download_logs')
                ->select('product_id', DB::raw('COUNT(*) as total_downloads'))
                ->groupBy('product_id')
                ->orderByDesc('total_downloads')
                ->limit(3)
                ->get();

            $productIds = $popular->pluck('product_id');

            return Product::whereIn('id', $productIds)
                ->where('status', 'published')
                ->get()
                ->sortByDesc(fn($product) => $popular->firstWhere('product_id', $product->id)->total_downloads);
        });

        return view('welcome', compact('latestProducts', 'userCount', 'featuredProduct', 'freeProducts', 'topDownloads'));
    }
}
