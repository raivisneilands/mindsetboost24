<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        // eager load categories (many-to-many)
        $products = Product::with('categories')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'file_path' => 'required|file|mimes:pdf,zip,docx',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        // create slug from title
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('products/files', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('products/images', 'public');
        }

        // create product (exclude categories)
        $categories = $validated['categories'];
        unset($validated['categories']);

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        // attach categories (many-to-many)
        $product->categories()->attach($categories);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('categories');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('categories');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'file_path' => 'nullable|file|mimes:pdf,zip,docx',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']);


        // Handle cover image if uploaded
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('product_covers', 'public');
        } else {
            unset($validated['cover_image']); // Keep existing
        }

        // Handle product file if uploaded
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('product_files', 'public');
        } else {
            unset($validated['file_path']); // Keep existing
        }


        $categories = $validated['categories'];
        unset($validated['categories']);

        $product->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        // sync categories
        $product->categories()->sync($categories);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
