<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']); // ✅ Public (no token needed)

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // ✅ Needs token
    Route::get('/user', fn(Request $request) => $request->user()); // ✅ Needs token
    
});
Route::get('/banners', [BannerController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/coupons', [CouponController::class,'index']);              
Route::post('/coupons/apply', [CouponController::class,'applyCoupon']); 
Route::post('/coupons', [CouponController::class,'store']);


