// Nom du fichier : 2026_05_04_000001_create_localisations_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('localisations', function (Blueprint $table) {
            $table->id();
            $table->string('street_line_1', 60);
            $table->string('street_line_2', 60)->nullable();
            $table->string('city', 50);
            $table->string('postal_code', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('localisations');
    }
};