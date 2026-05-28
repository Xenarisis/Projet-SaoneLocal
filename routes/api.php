<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

// =======================================================
// PUBLIC ROUTES (No token required)
// =======================================================
Route::prefix('users')->group(function () {
    // --- (POST) ---
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('products')->group(function () {
    // --- (GET) ---
    Route::get('/', [ProductController::class, 'get']);
    Route::get('/{product}', [ProductController::class, 'getProductById']);
});

// =======================================================
// PRIVATE ROUTES (Token JWT required)
// =======================================================
Route::group(['middleware' => 'auth:api'], function () {

    Route::prefix('users')->group(function () {
        // --- (GET) ---
        Route::get('/', [UserController::class, 'getAll']);
        Route::get('/{user}', [UserController::class, 'getUserById']);
        Route::get('/email/{email}', [UserController::class, 'getUserByEmail']);
        Route::get('/GoogleToken/{token}', [UserController::class, 'getUserByGoogleToken']);
        Route::get('/username/{username}', [UserController::class, 'getUserByUsername']);

        // --- (POST) ---
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        // --- (PUT) ---
        Route::put('/{user}', [UserController::class, 'putUser']);

        // --- (PATCH) ---
        Route::patch('/{user}', [UserController::class, 'patchUser']);

        // --- (DELETE) ---
        Route::delete('/{user}', [UserController::class, 'deleteUser']);
    });

    Route::prefix('products')->group(function () {
        // --- (POST) ---
        Route::post('/new', [ProductController::class, 'createProduct']);

        // --- (PUT) ---
        Route::put('/{product}', [ProductController::class, 'putProduct']);

        // --- (PATCH) ---
        Route::patch('/{product}', [ProductController::class, 'patchProduct']);;

        // --- (Delete) ---
        Route::delete('/{product}', [ProductController::class, 'deleteProduct']);
    });

    Route::prefix('orders')->group(function () {
        // --- (GET) ---
        Route::get('/', [OrderController::class, 'getAll']);
        Route::get('/{order}', [OrderController::class, 'getOrderById']);
        Route::get('/number/{orderNumber}', [OrderController::class, 'getOrderByOrderNumber']);

        // --- (POST) ---
    });

});