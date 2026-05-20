<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create([
            'email' => 'filouche39@gmail.com',
            'firstname' => 'Félicien',
            'lastname' => 'Nachon',
            'username' => 'filouche',
            'role' => 'admin',
            'password' => Hash::make('admin123')
        ]);

        User::factory()->count(50)->create();
    }
}
