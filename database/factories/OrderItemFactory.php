<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()?->id,
            'quantity'   => $this->faker->numberBetween(1, 3),
            'price'      => function (array $attributes) {
                return Product::find($attributes['product_id'])?->price ?? 10.00;
            },
        ];
    }
}
