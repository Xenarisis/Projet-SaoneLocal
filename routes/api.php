<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// ############## Users

// ############## GET
// Appelle la méthode getAll() -> URL : /api/users
Route::get('/users', [UserController::class, 'getAll']);

// Appelle getUserWithId($id) -> URL : /api/users/1
Route::get('/users/{id}', [UserController::class, 'getUserWithId']);

// Appelle getUserWithEmail($email) -> URL : /api/users/email/jean@test.com
Route::get('/users/email/{email}', [UserController::class, 'getUserWithEmail']);