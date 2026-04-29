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
        Schema::table('command', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        });

        // Schema::table('products', function (Blueprint $table) {
        //     $table->foreignId('opinion_id')->constrained('opinion')->onDelete('cascade');
        // });
        
        Schema::table('opinion', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        });
        
        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('command', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('producer_id');
            $table->dropConstrainedForeignId('product_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('opinion_id');
        });

        Schema::table('opinion', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
        });

        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};