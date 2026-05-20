<?php

namespace Database\Seeders;

use App\Models\Cart_item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Cart_itemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cart_item::factory()->count(10)->create();
    }
}
