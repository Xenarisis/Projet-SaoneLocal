<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        \Illuminate\Support\Facades\DB::disableQueryLog();
        
        // Create an admin user who is also a producer
        $adminUser = User::create([
            'email' => 'admin@admin.admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'username' => 'admin',
            'role' => 'producer',
            'password' => \Illuminate\Support\Facades\Hash::make('admin'),
            'pdp_path' => null
        ]);

        $adminProducer = \App\Models\Producer::factory()->create([
            'user_id' => $adminUser->id,
            'name' => 'Ferme de l\'Admin',
        ]);

        \App\Models\Product::factory()->create([
            'producer_id' => $adminProducer->id,
            'name' => 'Escargot',
            'description' => 'De délicieux escargots élevés localement.',
            'price' => 12.50,
        ]);

        // Create 50 normal users
        $users = User::factory()->count(50)->create();

        // Create 15 producers (each factory creates a user with role 'producer')
        $producers = \App\Models\Producer::factory()->count(15)->create();

        // Ensure users of producers have the correct role (in case factory didn't set it due to mass assignment or model events)
        User::whereIn('id', $producers->pluck('user_id'))->update(['role' => 'producer']);

        // For each producer, create between 3 and 10 products
        $producers->each(function ($producer) use ($users) {
            $products = \App\Models\Product::factory()
                ->count(fake()->numberBetween(3, 10))
                ->create(['producer_id' => $producer->id]);

            // For each product, create between 0 and 5 reviews from random users
            $products->each(function ($product) use ($users) {
                $numReviews = fake()->numberBetween(0, 5);
                for ($i = 0; $i < $numReviews; $i++) {
                    \App\Models\Review::factory()->create([
                        'product_id' => $product->id,
                        'user_id' => $users->random()->id
                    ]);
                }
            });
        });
        
        // Let's call the other generic seeders for things that are not relational or we haven't rewritten yet
        $this->call([
            DiscountSeeder::class,
            ReduceSeeder::class,
            BookmarkSeeder::class,
            FollowSeeder::class,
            OrderSeeder::class,
            ComposeSeeder::class,
            CartItemSeeder::class,
            EventSeeder::class
        ]);
    }
}
