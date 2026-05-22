<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// =======================================================
// PUBLIC ROUTES (No token required)
// =======================================================
Route::prefix('users')->group(function () {
    Route::post('/register', [UserController::class, 'createUser']);
    Route::post('/login', [UserController::class, 'loginUser']);
});

// =======================================================
// PRIVATE ROUTES (Token Sanctum required)
// =======================================================
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('users')->group(function () {
        // --- (GET) ---
        Route::get('/', [UserController::class, 'getAll']);
        Route::get('/{id}', [UserController::class, 'getUserWithId']);
        Route::get('/email/{email}', [UserController::class, 'getUserWithEmail']);
        Route::get('/googleToken/{token}', [UserController::class, 'getUserWithGoogleToken']);
        Route::get('/username/{username}', [UserController::class, 'getUserWithUsername']);

        // --- (PUT/PATCH) ---
        Route::put('/{id}', [UserController::class, 'putUser']);
        Route::patch('/{id}', [UserController::class, 'patchUser']);

        // --- (DELETE) ---
        Route::delete('/{id}', [UserController::class, 'deleteUser']);
    });

});