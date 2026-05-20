<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Product::create([
            'name' => 'Escargot',
            'description' => 'Escargot prêt à l\'emploie frais pas chères gratuit',
            'price' => 3.5,
            'category' => 'Nourriture',
            'subcategory' => 'Frais',
            'producer_id' => 1
        ]);

        Product::factory()->count(50)->create();
    }
}
