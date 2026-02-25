<?php

namespace App\Http\Controllers;

use App\Models\ProductPack;
use Illuminate\Http\Request;

class ProductPackController extends Controller
{
    public function index()
    {
        $packs = ProductPack::with('products')->orderBy('created_at', 'desc')->paginate(10); // 10 per page
        return view('packs.index', compact('packs'));
    }

    public function show($slug)
    {
        $pack = ProductPack::where('slug', $slug)->with('products')->firstOrFail();

        return view('packs.show', compact('pack'));
    }
}
