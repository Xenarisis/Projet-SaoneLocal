<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Cart_itemSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Cart_item::factory()->count(10)->create();
    }
}
