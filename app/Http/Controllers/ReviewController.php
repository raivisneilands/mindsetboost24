<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => auth()->id()],
            ['rating' => $request->rating, 'review' => $request->review]
        );

        return back()->with('success', 'Review submitted!');
    }
    public function edit(Product $product)
    {
        $review = $product->reviews()->where('user_id', auth()->id())->firstOrFail();

        return view('reviews.edit', compact('product', 'review'));
    }

    public function update(Request $request, Product $product)
    {
        $review = $product->reviews()->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('products.show', $product->slug)->with('success', 'Review updated.');
    }

    public function destroy(Product $product)
    {
        $review = $product->reviews()->where('user_id', auth()->id())->firstOrFail();

        $review->delete();

        return redirect()->route('products.show', $product->slug)->with('success', 'Review deleted.');
    }

}
