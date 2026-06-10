<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'event_name'    => fake()->unique()->word(),
            'description'   => fake()->sentence(),
            'event_date'    => fake()->dateTimeBetween('now', '+5 year'),
            'street_line_1' => fake()->latitude(),
            'city'          => fake()->city(),
            'postal_code'   => fake()->postcode()
        ];
    }
}
