<?php

use App\Http\Controllers\admin\BlogCommentController;
use App\Http\Controllers\admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductCommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDetailController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckOutController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\BlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Front (Client)
Route::get('/', [HomeController::class, 'index']);
Route::view('/contact', 'front.contact');

Route::prefix('shop')->group(function() {
    Route::get('/', [ShopController::class, 'index']);
    Route::get('product/{id}', [ShopController::class, 'show']);
    Route::post('product/{id}', [ShopController::class, 'addCart']);
    Route::get('product/{id}/load-comment', [ShopController::class, 'loadComment']);
    Route::post('product/{id}/post-comment', [ShopController::class, 'postComment']);
    Route::get('category/{categoryName}', [ShopController::class, 'category']);
});

Route::prefix('cart')->group(function() {
    Route::get('add', [CartController::class, 'add']);
    Route::get('/', [CartController::class, 'index']);
    Route::get('delete', [CartController::class, 'delete']);
    Route::get('destroy', [CartController::class, 'destroy']);
    Route::get('update', [CartController::class, 'update']);
    Route::get('get-coupon', [CartController::class, 'getCoupon']);
    Route::get('remove-coupon', [CartController::class, 'removeCoupon']);
});

Route::prefix('checkout')->group(function() {
    Route::get('/', [CheckOutController::class, 'index']);
    Route::post('/', [CheckOutController::class, 'addOrder']);
    Route::get('/result', [CheckOutController::class, 'result']);
    Route::get('/vnPayCheck', [CheckOutController::class, 'vnPayCheck']);

});

Route::prefix('account')->group(function() {
    Route::get('/login', [AccountController::class, 'login']);
    Route::post('/login', [AccountController::class, 'checkLogin']);
    Route::get('/logout', [AccountController::class, 'logout']);
    Route::get('/register', [AccountController::class, 'register']);
    Route::post('/register', [AccountController::class, 'postRegister']);
    Route::get('/forgot-password', [AccountController::class, 'forgotPass']);
    Route::post('/forgot-password', [AccountController::class, 'postForgotPass']);
    Route::get('/reset-password/{id}/{token}', [AccountController::class, 'resetPass'])->name('account.resetPass');
    Route::post('/reset-password/{id}/{token}', [AccountController::class, 'postResetPass']);

    Route::prefix('my-order')->middleware('CheckMemberLogin')->group(function() {
        Route::get('/', [AccountController::class, 'myOrderIndex']);
        Route::get('/{id}', [AccountController::class, 'myOrderShow']);
    });

    Route::prefix('my-account')->middleware('CheckMemberLogin')->group(function() {
        Route::get('/', [AccountController::class, 'myAccountIndex']);
        Route::get('/edit', [AccountController::class, 'myAccountEdit']);
        Route::put('/edit', [AccountController::class, 'myAccountUpdate']);
    });
});

Route::prefix('blog')->group(function() {
    Route::get('/', [BlogController::class, 'index']);
    Route::get('{id}', [BlogController::class, 'show']);
    Route::get('{id}/load-comment', [BlogController::class, 'loadComment']);
    Route::post('{id}/post-comment', [BlogController::class, 'postComment']);
    Route::get('category/{categoryName}', [BlogController::class, 'category']);
});

//Dashboard (Admin)
Route::prefix('admin')->middleware('CheckAdminLogin')->group(function() {
    Route::redirect('', '/admin/dashboard');
    
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('/user', UserController::class);
    Route::resource('/category', ProductCategoryController::class);
    Route::resource('/brand', BrandController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/product/{product_id}/image', ProductImageController::class);
    Route::resource('/product/{product_id}/detail', ProductDetailController::class);
    Route::resource('/product/{product_id}/comment', ProductCommentController::class);
    Route::resource('/order', OrderController::class);
    Route::resource('/blog', AdminBlogController::class);
    Route::resource('/blog/{blog_id}/comment', BlogCommentController::class);
    Route::resource('/coupon', CouponController::class);

    Route::prefix('login')->group(function() {
        Route::get('/', [AdminHomeController::class, 'getLogin'])->withoutMiddleware('CheckAdminLogin');
        Route::post('/', [AdminHomeController::class, 'postLogin'])->withoutMiddleware('CheckAdminLogin');
    });

    Route::get('/logout', [AdminHomeController::class, 'logout']);
});