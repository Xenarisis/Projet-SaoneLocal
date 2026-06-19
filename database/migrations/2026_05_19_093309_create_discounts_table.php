<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            // Why not linking directly discounts table to order table instead of using reduce table as intermediate 
            $table->integer('discount_percent');
            $table->string('code_name', 30);
            $table->datetime('available_until');
            $table->integer('max_use')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('discounts');
    }
};
