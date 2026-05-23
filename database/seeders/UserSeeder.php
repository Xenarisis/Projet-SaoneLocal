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
            'email' => 'admin@admin.admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin')
        ]);

        User::factory()->count(50)->create();
    }
}
