<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // First, get all category IDs (assuming categories are already seeded)
        $categoryIds = Category::pluck('id')->toArray();

        Product::factory()->count(10)->create()->each(function ($product) use ($categoryIds) {
            // Attach 1 or more random categories to each product
            $randomCategoryIds = collect($categoryIds)->random(rand(1, 3))->toArray(); // 1 to 3 categories
            $product->categories()->attach($randomCategoryIds);
        });
    }
}
