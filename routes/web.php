<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = \App\Models\Product::latest()->take(8)->get();
    $producers = \App\Models\Producer::latest()->take(8)->get();
    return view('welcome', compact('products', 'producers'));
})->name('home');

Route::get('/products/{product}', function ($product) {
    $product = \App\Models\Product::findOrFail($product);
    return view('pages.product', compact('product'));
})->name('products.show');

Route::get('/producers/{producer}', function ($producer) {
    $producer = \App\Models\Producer::findOrFail($producer);
    return view('pages.producer', compact('producer'));
})->name('producers.show');

Route::get('/search', function () {
    $products = \App\Models\Product::all();
    $producers = \App\Models\Producer::all();
    return view('pages.search', compact('products', 'producers'));
})->name('search');

Route::get('/about', fn() => view('pages.about'))->name('about');

Route::get('/calendar', function () {
    $events = \App\Models\Event::all();
    return view(('pages.calendar'), compact('events'));
})->name('calendar');

Route::get('/mention-legale', fn() => view('pages.mentionlegale'))->name('mentionlegale');

Route::get('/contact', fn() => view('pages.contact'))->name('contact');

Route::get('/CGV', fn() => view('pages.CGV'))->name('CGV');

Route::get('/CGU', fn() => view('pages.CGU'))->name('CGU');


/*
|--------------------------------------------------------------------------
| Authentication (Guests Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::view('/register', 'users.register')->name('users.register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'users.login')->name('users.login');
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
| Profile and Session Management
|--------------------------------------------------------------------------
*/
Route::view('/profile', 'users.profile')->name('users.profile');
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