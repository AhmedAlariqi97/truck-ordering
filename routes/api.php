<?php

use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\AuthController;
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
// Route::post('/login', [AuthController::class, 'authenticate']);

// Protected routes
Route::group(['prefix' => '/auth'], function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login',[AuthController::class,'authenticate']);
        Route::get('/register',[AuthController::class,'register']);
        

    });
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/users', [UsersController::class, 'index']);
});
