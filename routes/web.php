<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProducerController;
use App\Models\Event;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/search', 'search')->name('search');
    Route::get('/about', 'about')->name('about');
});

Route::prefix('products')->group(function () {
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
});

Route::prefix('producers')->group(function () {
    Route::get('/{producer}', [ProducerController::class, 'show'])->name('producers.show');
});

Route::get('/calendar', function () {
    $events = Event::all();
    return view('pages.calendar', compact('events'));
})->name('calendar');

// Static Pages
Route::view('/settings', 'pages.settings')->name('parametres');
Route::view('/mention-legale', 'pages.mentionlegale')->name('mentionlegale');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/CGV', 'pages.CGV')->name('CGV');
Route::view('/CGU', 'pages.CGU')->name('CGU');

/*
|--------------------------------------------------------------------------
| Authentication (Guests Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('users.register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('users.login');
    Route::post('/login', [AuthController::class, 'login']);

    // Google Authentication
    Route::prefix('auth/google')->controller(GoogleController::class)->group(function () {
        Route::get('/redirect', 'redirect')->name('google.redirect');
        Route::get('/callback', 'callback')->name('google.callback');
        Route::get('/success', 'success')->name('google.success');
    });
});

/*
|--------------------------------------------------------------------------
| Profile, Cart and Orders (JS Authenticated)
|--------------------------------------------------------------------------
*/
Route::view('/profile', 'users.profile')->name('users.profile');
Route::view('/complete-profile', 'users.complete-profile')->name('complete-profile');
Route::view('/logout', 'auth.logout')->name('logout.page');
Route::view('/cart', 'shop.cart')->name('cart');
Route::view('/checkout', 'shop.checkout')->name('checkout');
Route::view('/orders', 'users.orders')->name('users.orders');

Route::prefix('producer')->name('producer.')->group(function () {
    Route::view('/dashboard', 'producers.dashboard')->name('dashboard');
    Route::view('/products/create', 'producers.products.form')->name('products.create');
    Route::view('/products/{product}/edit', 'producers.products.form')->name('products.edit');
});

/*
|--------------------------------------------------------------------------
| User & Producer Area (Authenticated via Laravel Session - if any)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        // profil, settings...
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