<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPack;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductPackController extends Controller
{
    public function index()
    {
        $packs = ProductPack::with('products')->latest()->paginate(15);
        return view('admin.packs.index', compact('packs'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.packs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'products' => 'required|array',
        ]);

        // Generate slug from title
        $slug = Str::slug($data['title']);

        $pack = ProductPack::create([
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'discount_percent' => $data['discount_percent'],
        ]);

        $pack->products()->sync($data['products']);

        $pack->final_price = $pack->discounted_price;
        $pack->save();

        return redirect()->route('admin.packs.index')->with('success', 'Product pack created successfully!');
    }

    public function edit(ProductPack $pack)
    {
        $products = Product::all();
        return view('admin.packs.edit', compact('pack', 'products'));
    }

    public function update(Request $request, ProductPack $pack)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'products' => 'required|array',
        ]);

        // Update slug if title changed
        if ($pack->title !== $data['title']) {
            $pack->slug = Str::slug($data['title']);
        }

        $pack->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'discount_percent' => $data['discount_percent'],
        ]);

        $pack->products()->sync($data['products']);
        $pack->final_price = $pack->total_price;
        $pack->save();

        return redirect()->route('admin.packs.index')->with('success', 'Product pack updated successfully!');
    }

    public function destroy(ProductPack $pack)
    {
        $pack->delete();
        return redirect()->route('admin.packs.index')->with('success', 'Product pack deleted.');
    }
}
