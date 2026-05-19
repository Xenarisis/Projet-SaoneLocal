// Nom du fichier : 2026_05_04_000002_create_producers_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('presentation')->nullable();
            $table->string('street_line_1', 60);
            $table->string('street_line_2', 60)->nullable();
            $table->string('city', 50);
            $table->string('postal_code', 20);
            $table->timestamps();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producers');
    }
};