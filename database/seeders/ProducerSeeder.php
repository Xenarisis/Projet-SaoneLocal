<?php

namespace Database\Seeders;

use App\Models\Producer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProducerSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Producer::create([
            'name' => 'Les vignerons',
            'presentation' => 'Nous sommes une petite entreprise familliale dont les valeurs de la vigne se transmettent de génération en génération',
            'street_line_1' => '1 rue du Berger',
            'street_line_2' => '',
            'city' => 'Chalon sur saône',
            'postal_code' => '71100',
            'user_id' => 1
        ]);

        Producer::factory()->count(50)->create();

        // Update all users who have a producer profile to 'producer' role
        // This is necessary because model events are disabled during seeding
        User::whereIn('id', Producer::pluck('user_id'))->update(['role' => 'producer']);
    }
}
