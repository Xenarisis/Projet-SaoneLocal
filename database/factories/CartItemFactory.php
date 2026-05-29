<?php

namespace Database\Factories;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class Cart_itemFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'quantity' => fake()->numberBetween(0, 100),
            'user_id' => \App\Models\User::factory(),
            'product_id' => \App\Models\Product::factory()
        ];
    }
}
