// Nom du fichier : 2026_05_04_000003_create_products_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyText('description')->nullable();
            $table->decimal('price', 5, 2);
            $table->integer('quantity');
            $table->timestamps();
            $table->string('category');
            $table->string('subcategory')->nullable();
            $table->foreignId('producer_id')->constrained('producers')->onDelete('cascade');
            $table->string('image_path')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};