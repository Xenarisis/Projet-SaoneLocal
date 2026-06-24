// Nom du fichier : 0001_01_01_000000_create_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Table Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('role')->default('user')->nullable();
            $table->string('password');
            $table->boolean('is_banned')->default(false);
            $table->dateTime('last_login')->nullable();
            $table->string('google_token')->unique()->nullable();
            $table->string('pdp_path')->nullable();
            $table->timestamps();
        });

        // Table Sessions (Laravel need it)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};