<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::view('/register', 'users.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
    Route::view('/login', 'users.login')->name('login');
});

Route::view('/test', 'users.test')->name('test');

Route::view('/ban', 'errors.banned')->name('banned.page');
