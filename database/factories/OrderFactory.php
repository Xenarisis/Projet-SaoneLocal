<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => fake()->unique()->numberBetween(0, 100) ,
            'status' => fake()->randomElement(['en cours', 'prêt', 'retirée']) ,
            'total_excl_tax' => fake()->randomFloat(2, 10, 500) ,
            'percentage_tax' => fake()->randomFloat(2, 5, 10) ,
            'payment_status' => fake()->randomElement(['pending', 'processing', 'completed']) , 
            'user_id' => \App\Models\User::factory()
        ];
    }
}
