<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ReduceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ComposeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\BookmarkController;

// =======================================================
// PUBLIC ROUTES (No token required)
// =======================================================
Route::match(['get', 'head'], '/', function () {
    return redirect()->route('health');
});

Route::match(['get', 'head'], '/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is running',
        'timestamp' => now()
    ], 200);
})->name('health');

Route::prefix('users')->group(function () {
    // --- (POST) ---
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('products')->group(function () {
    // --- (GET) ---
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
});

Route::prefix('reviews')->group(function () {
    // --- (GET) ---
    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/{review}', [ReviewController::class, 'show']);
});

// =======================================================
// PRIVATE ROUTES (Token JWT required)
// =======================================================
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('admin')->group(function () {
        // --- (PUT) ---
        Route::post('/toggle-ban/{user}', [AdminController::class, 'toggleBan']);
    });

    Route::prefix('users')->group(function () {
        // --- (GET) ---
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);

        // --- (POST) ---
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh']);

        // --- (PUT) ---
        Route::put('/{user}', [UserController::class, 'updatePut']);
        
        // --- (PATCH) ---
        Route::patch('/{user}', [UserController::class, 'updatePatch']);

        // --- (DELETE) ---
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('products')->group(function () {
        // --- (POST) ---
        Route::post('/', [ProductController::class, 'store']);

        // --- (PUT) ---
        Route::put('/{product}', [ProductController::class, 'updatePut']);
        
        // --- (PATCH) ---
        Route::patch('/{product}', [ProductController::class, 'updatePatch']);

        // --- (DELETE) ---
        Route::delete('/{product}', [ProductController::class, 'destroy']);
    });

    Route::prefix('orders')->group(function () {
        // --- (GET) ---
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{order}', [OrderController::class, 'show']);

        // --- (POST) ---
        Route::post('/', [OrderController::class, 'store']);

        // --- (PUT) ---
        Route::put('/{order}', [OrderController::class, 'updatePut']);
        
        // --- (PATCH) ---
        Route::patch('/{order}', [OrderController::class, 'updatePatch']);

        // --- (DELETE) ---
        Route::delete('/{order}', [OrderController::class, 'destroy']);
    });

    Route::prefix('follows')->group(function () {
        // --- (GET) ---
        Route::get('/', [FollowController::class, 'index']);
        Route::get('/{follow}', [FollowController::class, 'show']);

        // --- (POST) ---
        Route::post('/', [FollowController::class, 'store']);

        // --- (DELETE) ---
        Route::delete('/{follow}', [FollowController::class, 'destroy']);
    });

    Route::prefix('producers')->group(function () {
        // --- (GET) ---
        Route::get('/', [ProducerController::class, 'index']);
        Route::get('/{producer}', [ProducerController::class, 'show']);

        // --- (POST) ---
        Route::post('/', [ProducerController::class, 'store']);

        // --- (PUT) ---
        Route::put('/{producer}', [ProducerController::class, 'updatePut']);
        
        // --- (PATCH) ---
        Route::patch('/{producer}', [ProducerController::class, 'updatePatch']);    

        // --- (DELETE) ---
        Route::delete('/{producer}', [ProducerController::class, 'destroy']);
    });

    Route::prefix('reduces')->group(function () {
        // --- (GET) ---
        Route::get('/', [ReduceController::class, 'index']);
        Route::get('/{reduce}', [ReduceController::class, 'show']);

        // --- (POST) ---
        Route::post('/', [ReduceController::class, 'store']);

        // --- (DELETE) ---
        Route::delete('/{reduce}', [ReduceController::class, 'destroy']);
    });

    Route::prefix('cart-items')->group(function () {
        // --- (GET) ---
        Route::get('/', [CartItemController::class, 'index']);
        Route::get('/{cartItem}', [CartItemController::class, 'show']);

        // --- (POST) ---
        Route::post('/', [CartItemController::class, 'store']);

        // --- (PUT) ---
        Route::put('/{cartItem}', [CartItemController::class, 'updatePut']);
        
        // --- (PATCH) ---
        Route::patch('/{cartItem}', [CartItemController::class, 'updatePatch']);

        // --- (DELETE) ---
        Route::delete('/{cartItem}', [CartItemController::class, 'destroy']);
    });

    Route::prefix('reviews')->group(function () {
        // --- (POST) ---
        Route::post('/', [ReviewController::class, 'store']);

        // --- (PUT) ---
        Route::put('/{review}', [ReviewController::class, 'updatePut']); 
        
        // --- (PATCH) ---
        Route::patch('/{review}', [ReviewController::class, 'updatePatch']);

        // --- (DELETE) ---
        Route::delete('/{review}', [ReviewController::class, 'destroy']);
    });

    Route::prefix('bookmarks')->group(function () {
        // --- (GET) ---
        Route::get('/', [BookmarkController::class, 'index']);

        // --- (POST) ---
        Route::post('/', [BookmarkController::class, 'store']);

        // --- (DELETE) ---
        Route::delete('/{bookmark}', [BookmarkController::class, 'destroy']);
    });

    Route::prefix('discounts')->group(function () {
        // --- (GET) ---
        Route::get('/', [DiscountController::class, 'index']);
        Route::get('/{discount}', [DiscountController::class, 'show']);

        // --- (POST) ---
        Route::post('/', [DiscountController::class, 'store']);

        // --- (PUT) ---
        Route::put('/{discount}', [DiscountController::class, 'updatePut']);
        
        // --- (PATCH) ---
        Route::patch('/{discount}', [DiscountController::class, 'updatePatch']);

        // --- (DELETE) ---
        Route::delete('/{discount}', [DiscountController::class, 'destroy']);
    });

    Route::prefix('events')->group(function () {
        // --- (GET) ---
        Route::get('/', [EventController::class, 'index']);
        Route::get('/{event}', [EventController::class, 'show']);

        // --- (POST) ---
        Route::post('/', [EventController::class, 'store']);

        // --- (PUT) ---
        Route::put('/{event}', [EventController::class, 'updatePut']);
        
        // --- (PATCH) ---
        Route::patch('/{event}', [EventController::class, 'updatePatch']);

        // --- (DELETE) ---
        Route::delete('/{event}', [EventController::class, 'destroy']);
    });

    Route::prefix('composes')->group(function () {
        // --- (GET) ---
        Route::get('/', [ComposeController::class, 'index']);
        Route::get('/{compose}', [ComposeController::class, 'show']);
        
        // --- (POST) ---
        Route::post('/', [ComposeController::class, 'store']);

        // --- (PUT) ---
        Route::put('/{compose}', [ComposeController::class, 'updatePut']);
        
        // --- (PATCH) ---
        Route::patch('/{compose}', [ComposeController::class, 'updatePatch']);

        // --- (DELETE) ---
        Route::delete('/{compose}', [ComposeController::class, 'destroy']);
    });
});