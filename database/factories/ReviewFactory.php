<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => fake()->randomFloat(1, 0, 5),
            'comment' => fake()->sentence(),
            'user_id' => \App\Models\User::factory(),
            'product_id' => \App\Models\Product::factory()
        ];
    }
}
