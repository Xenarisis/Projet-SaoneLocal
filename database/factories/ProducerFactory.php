<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class ProducerFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $farmNames = [
            'Ferme de la Vallée', 'Le Fournil de Jean', 'Domaine des Vignes', 'Les Jardins de Sophie',
            'La Bergerie du Plateau', 'Miel et Nature', 'Boulangerie Tradition', 'Ferme Bio du Coin'
        ];

        return [
            'name' => fake()->randomElement($farmNames) . ' ' . fake()->citySuffix(),
            'presentation' => "Nous sommes des producteurs passionnés situés à " . fake()->city() . ". Nos produits sont cultivés et fabriqués avec amour et dans le respect des traditions locales. Venez découvrir notre savoir-faire !",
            'street_line_1' => fake()->streetAddress(),
            'street_line_2' => '',
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'user_id' => \App\Models\User::factory([
                'role' => 'producer',
                'pdp_path' => fake()->randomElement(['images/agriculteur.jpg', 'images/agricultrice.jpg', 'images/boulanger.jpg', 'images/boulanger2.jpg', 'images/producter.jpg', 'images/vigneron.jpg', 'images/producers.jpg'])
            ])
        ];
    }
}
