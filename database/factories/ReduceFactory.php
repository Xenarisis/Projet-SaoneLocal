<?php

namespace Database\Factories;

use App\Models\Reduce;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reduce>
 */
class ReduceFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'order_id' => \App\Models\Order::factory(),
            'discount_id' => \App\Models\Discount::factory()
        ];
    }
}
