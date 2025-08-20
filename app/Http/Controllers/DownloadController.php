<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\DownloadLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends Controller
{
    public function download(Request $request, Order $order, Product $product)
    {
        logger('Download method hit');
        // Ensure the product belongs to the order
        if (
            $order->user_id !== auth()->id() ||
            !$order->products->contains('id', $product->id)
        ) {
            abort(403, 'Unauthorized');
        }

        // Log the download
        DownloadLog::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'ip_address' => $request->ip(),
        ]);

        // Return file download
        return Storage::download($product->file_path, $product->title . '.pdf');
    }

    public function downloadFree(Request $request, Product $product)
    {
        logger('Free download hit');

        // Ensure the product is free
        if ($product->price > 0) {
            abort(403, 'This product is not free.');
        }

        // Optional: log the download
        DownloadLog::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'order_id' => null, // no order for free products
            'ip_address' => $request->ip(),
        ]);

        // Return file
        return Storage::download($product->file_path, $product->title . '.pdf');
    }
}
