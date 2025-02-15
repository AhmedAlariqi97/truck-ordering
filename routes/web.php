<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DiscountCouponsController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\admin\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/test', function () {
//     orderEmail(10);
// });

Route::get('/',[FrontController::class,'index'])->name('front.home');
Route::post('/send-contact-email', [FrontController::class, 'sendContactEmail'])->name('front.sendContactEmail');


Route::group(['prefix' => '/auth'], function(){

    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login',[AuthController::class,'login'])->name('auth.login');
        Route::post('/authenticate',[AuthController::class,'authenticate'])->name('auth.authenticate');
        Route::get('/register',[AuthController::class,'register'])->name('auth.register');
        Route::post('/process-register',[AuthController::class,'processRegister'])->name('auth.processRegister');
        
        Route::get('/forgot-password',[AuthController::class,'forgotPassword'])->name('auth.forgotPassword');
        Route::post('/process-forgot-password',[AuthController::class,'processForgotPassword'])->name('auth.processForgotPassword');
        Route::get('/reset-password/{token}',[AuthController::class,'resetPassword'])->name('auth.resetPassword');
        Route::post('/process-reset-password',[AuthController::class,'processResetPassword'])->name('auth.processResetPassword');

    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/profile',[AuthController::class,'profile'])->name('account.profile');
        Route::post('/update-profile',[AuthController::class,'updateProfile'])->name('account.updateProfile');
        Route::post('/update-address',[AuthController::class,'updateAddress'])->name('account.updateAddress');
        Route::get('/my-orders',[AuthController::class,'orders'])->name('account.myOrders');
        Route::get('/order-detial/{orderId}',[AuthController::class,'orderDetial'])->name('account.orderDetial');
        Route::get('/show-change-password',[AuthController::class,'showChangePassword'])->name('account.showChangePassword');
        Route::post('/change-password',[AuthController::class,'changePassword'])->name('account.changePassword');
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::get('/checkout',[CartController::class,'checkout'])->name('front.checkout');
        Route::post('/process-checkout',[CartController::class,'processCheckout'])->name('front.processCheckout');
        Route::get('/thanks/{orderId}',[CartController::class,'thankYou'])->name('front.thankYou');
        Route::post('/getOrderSummary',[CartController::class,'getOrderSummary'])->name('front.getOrderSummary');
        Route::post('/applyDiscount',[CartController::class,'applyDiscount'])->name('front.applyDiscount');
        Route::post('/removeCoupon', [CartController::class, 'removeCoupon'])->name('front.removeCoupon');


    });
});


Route::group(['prefix' => '/admin'], function(){

    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => ['auth']], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');

        //category route
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edite', [CategoryController::class, 'edite'])->name('categories.edite');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

          

           //discount Coupons route
           Route::get('/discountCoupons', [DiscountCouponsController::class, 'index'])->name('discount-coupons.index');
           Route::get('/discountCoupons/create', [DiscountCouponsController::class, 'create'])->name('discount-coupons.create');
           Route::post('/discountCoupons', [DiscountCouponsController::class, 'store'])->name('discount-coupons.store');
           Route::get('/discountCoupons/{discountCoupon}/edite', [DiscountCouponsController::class, 'edite'])->name('discount-coupons.edite');
           Route::put('/discountCoupons/{discountCoupon}', [DiscountCouponsController::class, 'update'])->name('discount-coupons.update');
           Route::delete('/discountCoupons/{discountCoupon}', [DiscountCouponsController::class, 'destroy'])->name('discount-coupons.delete');

           //orders route
         Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
         Route::get('/orders/{id}', [OrderController::class, 'detial'])->name('orders.detial');
         Route::post('/order/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');
         Route::post('/order/send-invoice-email/{id}', [OrderController::class, 'sendInvoiceEmail'])->name('orders.sendInvoiceEmail');

          //user route
          Route::get('/users', [UsersController::class, 'index'])->name('users.index');
          Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
          Route::post('/users', [UsersController::class, 'store'])->name('users.store');
          Route::get('/users/{user}/edite', [UsersController::class, 'edite'])->name('users.edite');
          Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
          Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.delete');


           //setting route
          Route::get('/show-change-password',[SettingController::class,'showChangePassword'])->name('admin.showChangePassword');
          Route::post('/change-password',[SettingController::class,'changePassword'])->name('admin.changePassword');


        

        // temp-images.create
        Route::post('/temp', [TempImagesController::class, 'create'])->name('temp-images.create');

        

        Route::get('/getSlug',function(Request $request){
            $slug = '';
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }

            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');

        // Route for storing the file input content in the session
        Route::post('/store-file-content', 'Categories@storeFileContent')->name('storeFileContent');

          // Route for auto-complete functionality
        Route::get('/autocomplete', 'Categories@autocomplete')->name('autocomplete');
    });
});
