<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Bookmark::create([
            'user_id' => 1,
            'product_id' => 1
        ]);

        Bookmark::factory()->count(10)->create();
    }
}
