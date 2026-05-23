<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

// =======================================================
// PUBLIC ROUTES (No token required)
// =======================================================
Route::prefix('users')->group(function () {
    // --- (POST) ---
    Route::post('/register', [UserController::class, 'createUser']);
    Route::post('/login', [UserController::class, 'loginUser']);
});

Route::prefix('products')->group(function () {
    // --- (GET) ---
    Route::get('/', [ProductController::class, 'get']);
    Route::get('/{id}', [ProductController::class, 'getProductById']);
});

// =======================================================
// PRIVATE ROUTES (Token Sanctum required)
// =======================================================
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('users')->group(function () {
        // --- (GET) ---
        Route::get('/', [UserController::class, 'getAll']);
        Route::get('/{id}', [UserController::class, 'getUserById']);
        Route::get('/email/{email}', [UserController::class, 'getUserByEmail']);
        Route::get('/googleToken/{token}', [UserController::class, 'getUserByGoogleToken']);
        Route::get('/username/{username}', [UserController::class, 'getUserByUsername']);

        // --- (PUT/PATCH) ---
        Route::put('/{id}', [UserController::class, 'putUser']);
        Route::patch('/{id}', [UserController::class, 'patchUser']);

        // --- (DELETE) ---
        Route::delete('/{id}', [UserController::class, 'deleteUser']);
    });

    Route::prefix('products')->group(function () {
        // --- (POST) ---
        Route::post('/new', [ProductController::class, 'createProduct']);
    });

});