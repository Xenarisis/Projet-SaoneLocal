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
            'discount' => fake()->numberBetween(1, 100),
            'code_name' => fake()->numerify('#########'),
            'availibility' => fake()->dateTimeBetween('now', '+1 month')
        ];
    }
}
