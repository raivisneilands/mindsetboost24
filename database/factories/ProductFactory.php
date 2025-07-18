<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'cover_image' => 'dummy/path/to/cover.jpg', // replace when upload handled
            'file_path' => 'dummy/path/to/file.pdf',    // replace when upload handled
            'status' => $this->faker->randomElement(['draft', 'published']),
            // 'category_id' => Category::inRandomOrder()->first()->id ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
