<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/register')

Route::view('/ban', 'errors.banned')->name('banned.page');
