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

Route::get('/avatars/{filename}', [UserController::class, 'showAvatar'])
    ->name('avatar.show')
    ->middleware('signed');

Route::prefix('users')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('products')->group(function () {

    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
});

Route::prefix('reviews')->group(function () {

    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/{review}', [ReviewController::class, 'show']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('admin')->group(function () {

        Route::post('/toggle-ban/{user}', [AdminController::class, 'toggleBan']);
    });

    Route::prefix('users')->group(function () {

        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/complete-profile', [AuthController::class, 'completeProfile']);

        Route::put('/{user}', [UserController::class, 'updatePut']);

        Route::patch('/{user}', [UserController::class, 'updatePatch']);

        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('products')->group(function () {

        Route::post('/', [ProductController::class, 'store']);

        Route::put('/{product}', [ProductController::class, 'updatePut']);

        Route::patch('/{product}', [ProductController::class, 'updatePatch']);

        Route::delete('/{product}', [ProductController::class, 'destroy']);
    });

    Route::prefix('orders')->group(function () {

        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{order}', [OrderController::class, 'show']);

        Route::post('/', [OrderController::class, 'store']);

        Route::put('/{order}', [OrderController::class, 'updatePut']);

        Route::patch('/{order}', [OrderController::class, 'updatePatch']);

        Route::delete('/{order}', [OrderController::class, 'destroy']);
    });

    Route::prefix('follows')->group(function () {

        Route::get('/', [FollowController::class, 'index']);
        Route::get('/{follow}', [FollowController::class, 'show']);

        Route::post('/', [FollowController::class, 'store']);

        Route::delete('/{follow}', [FollowController::class, 'destroy']);
    });

    Route::prefix('producers')->group(function () {

        Route::get('/', [ProducerController::class, 'index']);
        Route::get('/{producer}', [ProducerController::class, 'show']);

        Route::post('/', [ProducerController::class, 'store']);

        Route::put('/{producer}', [ProducerController::class, 'updatePut']);

        Route::patch('/{producer}', [ProducerController::class, 'updatePatch']);    

        Route::delete('/{producer}', [ProducerController::class, 'destroy']);
    });

    Route::prefix('reduces')->group(function () {

        Route::get('/', [ReduceController::class, 'index']);
        Route::get('/{reduce}', [ReduceController::class, 'show']);

        Route::post('/', [ReduceController::class, 'store']);

        Route::delete('/{reduce}', [ReduceController::class, 'destroy']);
    });

    Route::prefix('cart-items')->group(function () {

        Route::get('/', [CartItemController::class, 'index']);
        Route::get('/{cartItem}', [CartItemController::class, 'show']);

        Route::post('/', [CartItemController::class, 'store']);

        Route::put('/{cartItem}', [CartItemController::class, 'updatePut']);

        Route::patch('/{cartItem}', [CartItemController::class, 'updatePatch']);

        Route::delete('/{cartItem}', [CartItemController::class, 'destroy']);
    });

    Route::prefix('reviews')->group(function () {

        Route::post('/', [ReviewController::class, 'store']);

        Route::put('/{review}', [ReviewController::class, 'updatePut']); 

        Route::patch('/{review}', [ReviewController::class, 'updatePatch']);

        Route::delete('/{review}', [ReviewController::class, 'destroy']);
    });

    Route::prefix('bookmarks')->group(function () {

        Route::get('/', [BookmarkController::class, 'index']);

        Route::post('/', [BookmarkController::class, 'store']);

        Route::delete('/{bookmark}', [BookmarkController::class, 'destroy']);
    });

    Route::prefix('discounts')->group(function () {

        Route::get('/', [DiscountController::class, 'index']);
        Route::get('/{discount}', [DiscountController::class, 'show']);

        Route::post('/', [DiscountController::class, 'store']);

        Route::put('/{discount}', [DiscountController::class, 'updatePut']);

        Route::patch('/{discount}', [DiscountController::class, 'updatePatch']);

        Route::delete('/{discount}', [DiscountController::class, 'destroy']);
    });

    Route::prefix('events')->group(function () {

        Route::get('/', [EventController::class, 'index']);
        Route::get('/{event}', [EventController::class, 'show']);

        Route::post('/', [EventController::class, 'store']);

        Route::put('/{event}', [EventController::class, 'updatePut']);

        Route::patch('/{event}', [EventController::class, 'updatePatch']);

        Route::delete('/{event}', [EventController::class, 'destroy']);
    });

    Route::prefix('composes')->group(function () {

        Route::get('/', [ComposeController::class, 'index']);
        Route::get('/{compose}', [ComposeController::class, 'show']);

        Route::post('/', [ComposeController::class, 'store']);

        Route::put('/{compose}', [ComposeController::class, 'updatePut']);

        Route::patch('/{compose}', [ComposeController::class, 'updatePatch']);

        Route::delete('/{compose}', [ComposeController::class, 'destroy']);
    });
});