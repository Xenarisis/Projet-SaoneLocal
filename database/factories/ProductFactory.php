<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $products = [
            ['name' => 'Tomates Bio', 'category' => 'Légumes', 'min_price' => 2, 'max_price' => 5],
            ['name' => 'Salade verte', 'category' => 'Légumes', 'min_price' => 1, 'max_price' => 2.5],
            ['name' => 'Pommes de terre (5kg)', 'category' => 'Légumes', 'min_price' => 3, 'max_price' => 6],
            ['name' => 'Carottes fraîches', 'category' => 'Légumes', 'min_price' => 1.5, 'max_price' => 3],
            ['name' => 'Pain de Campagne', 'category' => 'Boulangerie', 'min_price' => 2, 'max_price' => 4],
            ['name' => 'Baguette Tradition', 'category' => 'Boulangerie', 'min_price' => 1.10, 'max_price' => 1.50],
            ['name' => 'Saucisson Artisanal', 'category' => 'Viande', 'min_price' => 5, 'max_price' => 9],
            ['name' => 'Poulet Fermier', 'category' => 'Viande', 'min_price' => 10, 'max_price' => 20],
            ['name' => 'Miel de Lavande', 'category' => 'Miel & Confiture', 'min_price' => 6, 'max_price' => 12],
            ['name' => 'Confiture de Fraise', 'category' => 'Miel & Confiture', 'min_price' => 4, 'max_price' => 7],
            ['name' => 'Vin Rouge Local', 'category' => 'Boissons', 'min_price' => 7, 'max_price' => 15],
            ['name' => 'Jus de Pomme artisanal', 'category' => 'Boissons', 'min_price' => 3, 'max_price' => 5],
            ['name' => 'Oeufs Plein Air (x6)', 'category' => 'Produits Laitiers & Oeufs', 'min_price' => 2, 'max_price' => 4],
            ['name' => 'Fromage de Chèvre', 'category' => 'Produits Laitiers & Oeufs', 'min_price' => 3, 'max_price' => 6],
        ];

        $product = fake()->randomElement($products);

        return [
            'name' => $product['name'],
            'description' => fake()->text(200),
            'price' => fake()->randomFloat(2, $product['min_price'], $product['max_price']),
            'quantity' => fake()->numberBetween(5, 50),
            'category' => $product['category'],
            'subcategory' => '',
            'producer_id' => \App\Models\Producer::factory(),
            'image_path' => fake()->randomElement(['images/pain.jpg', 'images/product.jpg', 'images/vin.jpg', 'images/salade.jpg'])
        ];
    }
}
