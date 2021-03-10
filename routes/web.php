<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExportPDFController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\AddressController;
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
    Session::forget('user_id');
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
// myorders export to PDF
Route::get('myorders/export_to_pdf',[ExportPDFController::class,'ordersExportPDF']);
// for myorders's PDF
Route::get('myordersPDF',[ExportPDFController::class,'ordersPDF']);
// export Excel
Route::get('myorders/export_to_excel',[ExcelController::class,'ordersExcel']);
Route::get('myorders/test_page',[ExcelController::class,'callModel']);


// admin
// add Mutilple Account
Route::get('/admin/add_mutil_account', [AdminController::class,'addMutilpleAccountPage']);
Route::post('/admin/add_mutil_account', [AdminController::class,'addMutilpleAccount']);

Route::get('/admin/add',[AdminController::class,'addAccountListPage']);
Route::post('/admin/add',[AdminController::class,'addAccount']);
Route::get('/admin/list',[AdminController::class,'userAccountList']);
Route::get('/admin/edit/{id}',[AdminController::class,'updateUserAccountPage']);
Route::post('/admin/edit/{id}',[AdminController::class,'updateUserAccount']);
Route::delete('/admin/{id}',[AdminController::class,'deleteUserAccount']);
// original page to modify user account
Route::post('/admin/{id}',[AdminController::class,'updateUserAccountOriginPage']);

// try
Route::get('/admin/account_search',[AdminController::class,'searchAccount']);

// Ajax
Route::get('/admin/account_search/{select_id}',[AdminController::class,'jsonData']);
Route::get('/admin/account_search/second/{select_id}',[AdminController::class,'jsonDataSecond']);

// address
//Route::get('/admin/add',[AddressController::class,'index']);
Route::get('/admin/add/{county}',[AddressController::class,'jsonDataCity']);
Route::get('/admin/add/{county}/{city}',[AddressController::class,'jsonDataZip']);
// 編輯頁 下拉選單縣市連棟鄉鎮市區
Route::get('/admin/edit/{id}/{county}',[AddressController::class,'jsonDataEditCity']);
Route::get('/admin/edit/{id}/{county}/{city}',[AddressController::class,'jsonDataEditZip']);



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
