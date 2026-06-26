<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/register', 'users.register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::view('/test', 'users.test')->name('test');

Route::view('/login', 'users.login')->name('login');

Route::view('/ban', 'errors.banned')->name('banned.page');
