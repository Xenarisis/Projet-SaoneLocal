<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Discount::create([
            'discount_percent' => 67,
            'code_name' => 'Mathys',
            'available_until' => '2026-05-22'
        ]);

        Discount::factory()->count(5)->create();
    }
}
