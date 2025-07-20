<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownloadLog;
use Illuminate\Http\Request;

class DownloadLogController extends Controller
{
    public function index(Request $request)
    {
        $query = DownloadLog::with(['user', 'product', 'order']);

        // Optional filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $logs = $query->latest()->paginate(20);

        return view('admin.download_logs.index', compact('logs'));
    }
}

