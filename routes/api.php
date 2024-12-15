<?php

use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/auth/login', [AuthController::class, 'authenticate']);
Route::post('/auth/register', [AuthController::class, 'processRegister']);
Route::post('/auth/forgot-password', [AuthController::class, 'processForgotPassword']);
Route::post('/auth/reset-password', [AuthController::class, 'processResetPassword']);
Route::post('/contact', [FrontController::class, 'sendContactEmail']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User Profile & Account
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/address', [AuthController::class, 'updateAddress']);
    Route::get('/orders', [AuthController::class, 'orders']);
    Route::get('/orders/{orderId}', [AuthController::class, 'orderDetail']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Cart & Checkout
    Route::get('/checkout/summary', [CartController::class, 'getOrderSummary']);
    Route::post('/checkout/process', [CartController::class, 'processCheckout']);
    Route::post('/discount/apply', [CartController::class, 'applyDiscount']);
    Route::post('/discount/remove', [CartController::class, 'removeCoupon']);

    // Admin Routes
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
        
        // Categories
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::get('/categories/{category}', [CategoryController::class, 'show']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
        
        // Users Management
        Route::get('/users', [UsersController::class, 'index']);
        
        // Orders Management
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);
    });
});
