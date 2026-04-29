<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('command', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producer_id')->constrained('users')->onDelete('cascade');
            $table->string('follower_number', 50);
            $table->datetime('date_creation');
            $table->string('status', 50);
            $table->decimal('total_amount_et');
            $table->decimal('total_amount_ati');
            $table->string('payment_status');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('product_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('command');
    }
};
