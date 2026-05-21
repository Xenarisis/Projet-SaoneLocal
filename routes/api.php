<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// ############## Users ##############

// ############## GET ##############
Route::get('/users', [UserController::class, 'getAll']);
Route::get('/users/{id}', [UserController::class, 'getUserWithId']);
Route::get('/users/email/{email}', [UserController::class, 'getUserWithEmail']);

// ############## POST ##############
Route::post('/users', [UserController::class, 'createUser']);