<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Producer;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $producerIds = Producer::pluck('id')->toArray();

        if (empty($producerIds)) return;

        Event::factory()->count(10)->create()->each(function ($event) use ($producerIds) {
            $randomProducers = array_rand(array_flip($producerIds), rand(1, 3));
            $event->producers()->attach((array)$randomProducers);
        });
    }
}