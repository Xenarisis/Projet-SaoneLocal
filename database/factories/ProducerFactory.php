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
        return [
            'name' => fake()->unique()->company(),
            'presentation' => fake()->paragraph(),
            'street_line_1' => fake()->latitude(),
            'street_line_2' => fake()->longitude(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'user_id' => \App\Models\User::factory([
                'pdp' => fake()->randomElement(["{{ asset('images/agriculteur.jpg')}}", "{{ asset('images/agricultrice.jpg')}}", "{{ asset('images/boulanger.jpg')}}", "{{ asset('images/boulanger2.jpg')}}", "{{ asset('images/producter.jpg')}}"])
            ])
        ];
    }
}
