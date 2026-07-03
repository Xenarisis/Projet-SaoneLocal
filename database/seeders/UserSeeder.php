<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create([
            'email' => 'admin@admin.admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin'),
            'pdp_path' => null
        ]);
        // rajouter les users présents dans le projet + police + zoom sur tel + squelette

        User::factory()->count(50)->create();
    }
}
