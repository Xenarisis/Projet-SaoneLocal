<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/search', fn() => view('search'))->name('search');

/*
|--------------------------------------------------------------------------
| Authentication (Guests Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::view('/register', 'users.register')->name('register');
        Route::post('/register', [AuthController::class, 'register']);

        Route::view('/login', 'users.login')->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Google Authentication
    Route::prefix('auth/google')->controller(GoogleController::class)->group(function () {
        Route::get('/redirect', 'redirect')->name('google.redirect');
        Route::get('/callback', 'callback')->name('google.callback');
        Route::get('/success', 'success')->name('google.success');
    });
});

/*
|--------------------------------------------------------------------------
| Profile and Session Management
|--------------------------------------------------------------------------
*/
Route::view('/complete-profile', 'users.complete-profile')->name('complete-profile');
Route::view('/logout', 'users.logout')->name('logout.page');

/*
|--------------------------------------------------------------------------
| User & Producer Area (Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        // profil, settings...
    });

    Route::prefix('producers')->name('producers.')->group(function () {
        // pages producteurs...
    });
});

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // dashboard admin...
});

/*
|--------------------------------------------------------------------------
| Errors & Testing
|--------------------------------------------------------------------------
*/
Route::view('/ban', 'errors.banned')->name('banned.page');
Route::view('/test', 'users.test')->name('test');