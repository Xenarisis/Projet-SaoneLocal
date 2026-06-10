<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CartItemSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        CartItem::factory()->count(10)->create();
    }
}
