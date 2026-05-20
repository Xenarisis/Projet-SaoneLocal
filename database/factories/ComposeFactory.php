<?php

namespace Database\Factories;

use App\Models\Compose;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Compose>
 */
class ComposeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(0, 100),
            'unit_price' => fake()->randomFloat(2, 2, 10),
            'order_id' => \App\Models\Order::factory(),
            'product_id' => \App\Models\Product::factory()
        ];
    }
}
