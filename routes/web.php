<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', fn() => view('welcome'))->name('home');

Route::get('/search', fn() => view('search'))->name('search');

// Guest only
Route::middleware('guest')->prefix('users')->name('users.')->group(function () {
    Route::view('/register', 'users.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'users.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Auth required
Route::middleware('auth')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        // profil, settings...
    });

    Route::prefix('producers')->name('producers.')->group(function () {
        // pages producteurs...
    });
});

// Admin only
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // dashboard admin...
});