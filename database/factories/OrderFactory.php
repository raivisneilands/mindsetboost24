<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::inRandomOrder()->first()?->id,
            'status'      => $this->faker->randomElement(['pending', 'processing', 'completed']),
            'total_price' => 0, // Will update after items
        ];
    }
}
