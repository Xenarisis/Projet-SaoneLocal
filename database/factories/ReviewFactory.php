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
        $reviews = [
            'Produit excellent, je recommande !',
            'Très bonne qualité, mais un peu cher.',
            'Je rachèterai sans hésiter.',
            'Un délice, toute la famille a adoré.',
            'Correct, mais j\'attendais mieux.',
            'Parfait, très bon rapport qualité/prix.',
            'Pas mal, à tester.',
            'Le goût est vraiment authentique.',
            'Superbe qualité, producteur au top.',
            'Bof, je suis un peu déçu.',
            'Excellent produit du terroir !'
        ];

        return [
            'rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->randomElement($reviews),
            'user_id' => \App\Models\User::factory(),
            'product_id' => \App\Models\Product::factory()
        ];
    }
}
