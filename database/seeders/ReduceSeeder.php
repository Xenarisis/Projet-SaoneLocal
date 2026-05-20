<?php

namespace Database\Seeders;

use App\Models\Reduce;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReduceSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Reduce::factory()->count(3)->create();
    }
}
