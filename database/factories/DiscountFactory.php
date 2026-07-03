<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Discount>
 */
class DiscountFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'discount_percent' => fake()->numberBetween(1, 100),
            'code_name' => fake()->numerify('#########'),
            'available_until' => fake()->dateTimeBetween('now', '+1 month')
        ];
    }
}
