<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 5);
        return [
            'product_title' => $product->title,
            'price' => $product->price,
            'quantity' => $this->faker->numberBetween(1, 5),
            'admin_revenue' => 0.9 * $product->price * $quantity,
            'ambassador_revenue' => 0.1 * $product->price * $quantity
        ];
    }
}
