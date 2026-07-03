<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class ConvertImagesToWebp extends Command {
    protected $signature = 'images:webp';
    protected $description = 'Convert existing product and avatar images to WebP';

    public function handle() {
        $manager = new ImageManager(new Driver());
        $this->info('Starting conversion...');

        $products = Product::whereNotNull('image_path')->get();
        foreach ($products as $product) {
            if (!str_ends_with(strtolower($product->image_path), '.webp')) {
                $filename = basename($product->image_path);
                $path = 'products/' . $filename;
                
                if (Storage::disk('public')->exists($path)) {
                    $fullPath = Storage::disk('public')->path($path);
                    try {
                        $image = $manager->read($fullPath);
                        $encoded = $image->toWebp(80);
                        
                        $newFilename = uniqid() . '.webp';
                        $newPath = 'products/' . $newFilename;
                        
                        Storage::disk('public')->put($newPath, $encoded->toString());
                        
                        Storage::disk('public')->delete($path);
                        
                        $product->image_path = $newFilename;
                        $product->save();
                        
                        $this->info("Converted product image: $path to $newPath");
                    } catch (\Exception $e) {
                        $this->error("Failed to convert product image $path: " . $e->getMessage());
                    }
                }
            }
        }

        $users = User::whereNotNull('pdp_path')->get();
        foreach ($users as $user) {
            if (!str_ends_with(strtolower($user->pdp_path), '.webp')) {
                $filename = basename($user->pdp_path);
                $path = 'avatars/' . $filename;
                
                if (Storage::disk('local')->exists($path)) {
                    $fullPath = Storage::disk('local')->path($path);
                    try {
                        $image = $manager->read($fullPath);
                        $encoded = $image->toWebp(80);
                        
                        $newFilename = uniqid() . '.webp';
                        $newPath = 'avatars/' . $newFilename;
                        
                        Storage::disk('local')->put($newPath, $encoded->toString());
                        
                        Storage::disk('local')->delete($path);
                        
                        $user->pdp_path = $newFilename;
                        $user->save();
                        
                        $this->info("Converted avatar: $path to $newPath");
                    } catch (\Exception $e) {
                        $this->error("Failed to convert avatar $path: " . $e->getMessage());
                    }
                }
            }
        }
        $this->info('Conversion complete!');
    }
}
