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
use App\Http\Controllers\EventController;
use App\Http\Controllers\ComposeController;

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
        //! Query string
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
        //! Query string
        Route::get('/{order}', [OrderController::class, 'getOrderById']);
        Route::get('/number/{orderNumber}', [OrderController::class, 'getOrderByOrderNumber']);

        // --- (POST) ---
        Route::post('/new', [OrderController::class, 'createOrder']);

        // --- (PUT) ---
        Route::put('/{order}', [OrderController::class, 'putOrder']);

        // --- (PATCH) ---
        Route::patch('/{order}', [OrderController::class, 'patchOrder']);

        // --- (DELETE) ---
        Route::delete('/{order}', [OrderController::class, 'deleteOrder']);
    });

    Route::prefix('follows')->group(function () {
        // --- (GET) ---
        //! Query string
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
        //! Query string
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
        //! Query string
        Route::get('/{reduce}', [ReduceController::class, 'getReduceByID']);

        // --- (POST) ---
        Route::post('/reduce', [ReduceController::class, 'createReduce']);

        // --- (DELETE) ---
        Route::delete('/remove/{reduce}', [ReduceController::class, 'deleteReduce']);
    });

    Route::prefix('cart')->group(function () {
        // --- (GET) ---
        Route::get('/{cartItem}', [CartItemController::class, 'getCartItemByID']);
        //! Query string
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
        //! Query string
        Route::get('/user/{user}', [BookmarkController::class, 'getUserBookmarks']);

        // --- (POST) ---
        Route::post('/product/{product}', [BookmarkController::class, 'addBookmark']);

        // --- (DELETE) ---
        Route::delete('/{bookmark}', [BookmarkController::class, 'deleteBookmark']);
    });

    Route::prefix('discounts')->group(function () {
        // --- (GET) ---
        Route::get('/', [DiscountController::class, 'getAll']);
        //! Query string
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

    Route::prefix('events')->group(function () {
        // --- (GET) ---
        Route::get('/', [EventController::class, 'getAll']);
        //! Query string
        Route::get('/{event}', [EventController::class, 'getEventByID']);
        Route::get('/name/{name}', [EventController::class, 'getEventByName']);
        Route::get('/date/{date}', [EventController::class, 'getEventByDate']);
        Route::get('/city/{city}', [EventController::class, 'getEventByCity']);
        Route::get('/postal_code/{postal_code}', [EventController::class, 'getEventByPostal_code']);

        // --- (POST) ---
        Route::post('/new', [EventController::class, 'createEvent']);

        // --- (PUT) ---
        Route::put('/{event}', [EventController::class, 'putEvent']);

        // --- (PATCH) ---
        Route::patch('/{event}', [EventController::class, 'patchEvent']);

        // --- (DELETE) ---
        Route::delete('/{event}', [EventController::class, 'deleteEvent']);
    });

    Route::prefix('composes')->group(function () {
        // --- (GET) ---
        Route::get('/', [ComposeController::class, 'getAll']);
        //! Query string
        Route::get('/{compose}', [ComposeController::class, 'getComposeByID']);
        
        // --- (POST) ---
        Route::post('/new', [ComposeController::class, 'createCompose']);

        // --- (PUT/PATCH) ---
        Route::put('/{compose}', [ComposeController::class, 'putCompose']);
        Route::patch('/{compose}', [ComposeController::class, 'putCompose']);

        // --- (DELETE) ---
        Route::delete('/{compose}', [ComposeController::class, 'deleteCompose']);
    });

});