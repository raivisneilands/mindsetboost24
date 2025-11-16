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

        $user = auth()->user();

        if ($user) {
            $downloadCount = DownloadLog::where('user_id', $user->id)->count();

            if ($downloadCount >= 1) $user->awardBadge('first-download');
            if ($downloadCount >= 5) $user->awardBadge('explorer');
            if ($downloadCount >= 10) $user->awardBadge('collector');
            if ($downloadCount >= 20) $user->awardBadge('power-user');
            if ($downloadCount >= 50) $user->awardBadge('mindset-master');
        }


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
