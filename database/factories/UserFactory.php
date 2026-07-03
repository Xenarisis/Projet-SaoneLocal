<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory {
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'email'     => fake()->unique()->safeEmail(),
            'firstname' => fake()->firstName(),
            'lastname'  => fake()->lastName(),
            'username'  => fake()->unique()->userName(),
            'role'      => 'user',
            'is_banned' => false,
            'password'  => static::$password ??= Hash::make('password'),
            'pdp_path'  => fake()->boolean(70) ? fake()->randomElement(['images/agriculteur.jpg', 'images/agricultrice.jpg', 'images/boulanger.jpg', 'images/boulanger2.jpg', 'images/producter.jpg', 'images/vigneron.jpg']) : null
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
