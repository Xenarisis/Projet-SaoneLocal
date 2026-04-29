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
            $table->string('follower_number', 50);
            $table->datetime('date_creation');
            $table->string('status', 50);
            $table->decimal('total_amount_et');
            $table->decimal('total_amount_ati');
            $table->string('payment_status');
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
