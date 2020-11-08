<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialiteController;
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

Route::get('/login', function () {
    return view('login');
});

Route::get('/logout', function () {
    Session::forget('user');
    return redirect('login');
});

Route::view('/register','register');
Route::post('/login',[UserController::class,'login']);
Route::post('/register',[UserController::class,'register']);
Route::get('/',[ProductController::class,'index']);
Route::get('detail/{id}',[ProductController::class,'detail']);
Route::get('search',[ProductController::class,'search']);
Route::post('add_to_cart',[ProductController::class,'addToCart']);
Route::get('cartlist',[ProductController::class,'cartList']);
Route::get('removecart/{id}',[ProductController::class,'removeCart']);
Route::get('ordernow',[ProductController::class,'orderNow']);
Route::post('orderplace',[ProductController::class,'orderPlace']);
Route::get('myorders',[ProductController::class,'myOrders']);


// Google 登入
Route::get('/google-sign-in', [SocialiteController::class,'googleSignInProcess']);
Route::get('/google-sign-in-callback', [SocialiteController::class,'googleSignInCallbackProcess']);

// Facebook 登入
Route::get('/facebook-sign-in', [SocialiteController::class,'facebookSignInProcess']);
// Facebook 登入重新導向授權資料處理
Route::get('/facebook-sign-in-callback', [SocialiteController::class,'facebookSignInCallbackProcess']);

// 第三方登入
Route::get('/facebook/link',[SocialiteController::class,'facebookLink']);
Route::get('/facebook/callback',[SocialiteController::class,'facebookCallback']);
