<?php

namespace Database\Seeders;

use App\Models\Compose;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Compose::factory()->count(10)->create();
    }
}
