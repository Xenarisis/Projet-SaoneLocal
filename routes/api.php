<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\ReduceController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\BookmarkController;

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

Route::prefix('reviews')->group(function () {
    // --- (GET) ---
    Route::get('/{review}', [ReviewController::class, 'getReviewById']);
    Route::get('/product/{product}', [ReviewController::class, 'getProductReviews']);
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

    Route::prefix('follows')->group(function () {
        // --- (GET) ---
        Route::get('/{follow}', [FollowController::class, 'getFollowById']);
        Route::get('/user/{user}', [FollowController::class, 'getUserFollow']);
        Route::get('/producer/{producer}', [FollowController::class, 'getProducerFollowers']);

        // --- (POST) ---
        Route::post('/producer/{producer}', [FollowController::class, 'createFollow']);

        // --- (DELETE) ---
        Route::delete('/producer/{producer}', [FollowController::class, 'deleteFollow']);
    });

    Route::prefix('producer')->group(function () {
        // --- (GET) ---
        Route::get('/', [ProducerController::class, 'getAll']);
        Route::get('/{producer}', [ProducerController::class, 'getProducerByID']);
        Route::get('/name/{name}', [ProducerController::class, 'getProducerByName']);
        Route::get('/city/{city}', [ProducerController::class, 'getProducerByCity']);
        Route::get('/postal_code/{postal_code}', [ProducerController::class, 'getProducerByPostal_code']);

        // --- (POST) ---
        Route::post('/add', [ProducerController::class, 'createProducer']);

        // --- (PUT) ---
        Route::put('/{producer}', [ProducerController::class, 'putProducer']);
        
        // --- (PATCH) ---
        Route::patch('/{producer}', [ProducerController::class, 'patchProducer']);    

        // --- (DELETE) ---
        Route::delete('/delete/{producer}', [ProducerController::class, 'deleteProducer']);
        });

        Route::prefix('reduce')->group(function () {
        // --- (GET) ---
        Route::get('/', [ReduceController::class, 'getAll']);
        Route::get('/{reduce}', [ReduceController::class, 'getReduceByID']);

        // --- (POST) ---
        Route::post('/reduce', [ReduceController::class, 'createReduce']);

        // --- (DELETE) ---
        Route::delete('/remove/{reduce}', [ReduceController::class, 'deleteReduce']);
    });

    Route::prefix('cart')->group(function () {
        // --- (GET) ---
        Route::get('/', [CartItemController::class, 'getCartItemByID']);
        Route::get('/user/{user}', [CartItemController::class, 'getCartItemByUserId']);
        Route::get('/product/{product}', [CartItemController::class, 'getCartItemByProductId']);

        // --- (POST) ---
        Route::post('/{product}', [CartItemController::class, 'addCartItem']);

        // --- (PUT) ---
        Route::put('/{cartItem}', [CartItemController::class, 'putCartItem']);

        // --- (PATCH) ---
        Route::patch('/{cartItem}', [CartItemController::class, 'patchCartItem']);

        // --- (DELETE) ---
        Route::delete('/{cartItem}', [CartItemController::class, 'deleteCartItem']);
    });

    Route::prefix('reviews')->group(function () {
        // --- (POST) ---
        Route::post('/product/{product}', [ReviewController::class, 'addReview']);

        // --- (PATCH) ---
        Route::patch('/{review}', [ReviewController::class, 'patchReview']);

        // --- (DELETE) ---
        Route::delete('/{review}', [ReviewController::class, 'deleteReview']);
    });

    Route::prefix('bookmarks')->group(function () {
        // --- (GET) ---
        Route::get('/user/{user}', [BookmarkController::class, 'getUserBookmarks']);

        // --- (POST) ---
        Route::post('/product/{product}', [BookmarkController::class, 'addBookmark']);

        // --- (DELETE) ---
        Route::delete('/{bookmark}', [BookmarkController::class, 'deleteBookmark']);
    });

    Route::prefix('discounts')->group(function () {
        // --- (GET) ---
        Route::get('/', [DiscountController::class, 'getAll']);
        Route::get('/{discount}', [DiscountController::class, 'getDiscountById']);
        Route::get('/code/{code_name}', [DiscountController::class, 'getDiscountByCodeName']);

        // --- (POST) ---
        Route::post('/new', [DiscountController::class, 'createDiscount']);

        // --- (PUT) ---
        Route::put('/{discount}', [DiscountController::class, 'putDiscount']);

        // --- (PATCH) ---
        Route::patch('/{discount}', [DiscountController::class, 'patchDiscount']);

        // --- (DELETE) ---
        Route::delete('/{discount}', [DiscountController::class, 'deleteDiscount']);
    });

});