<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_name' => fake()->word(),
            'description' => fake()->sentence(),
            'event_date' => fake()->dateTimeBetween('now', '+5 year'),
            'street_line_1' => fake()->latitude(),
            'street_line_2' => fake()->longitude(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'producer_id' => \App\Models\Producer::factory()
        ];
    }
}
