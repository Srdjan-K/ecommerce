<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;



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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [UserAuthController::class,'login'])->middleware('ALREADY_LOGGED_IN');
Route::get('register', [UserAuthController::class,'register'])->middleware('ALREADY_LOGGED_IN');
Route::post('create_new_user', [UserAuthController::class,'create_new_user'])->name('auth.create_new_user');
Route::post('check_login', [UserAuthController::class,'check_login'])->name('auth.check_login');
Route::get('profile', [UserAuthController::class,'profile'])->middleware('LOGGED_ADMIN');


Route::get('stores', [StoreController::class,'store_view'])->middleware('LOGGED_ADMIN');
Route::get('stores/{id}', [StoreController::class,'get_specific_store'])->middleware('LOGGED_ADMIN');
Route::post('add_new_store', [StoreController::class,'add_new_store'])->name('add_new_store');
Route::get('delete_specific_store/{id}', [StoreController::class,'delete_specific_store'])->name('delete_specific_store');
Route::get('update_existing_store/{id}', [StoreController::class,'update_existing_store'])->name('update_existing_store');
Route::post('update_and_save_existing_store', [StoreController::class,'update_and_save_existing_store'])->name('update_and_save_existing_store');


Route::get('products', [ProductController::class,'product_view'])->middleware('LOGGED_ADMIN');
Route::get('products/{id}', [ProductController::class,'get_specific_product'])->middleware('LOGGED_ADMIN');
Route::post('add_new_product', [ProductController::class,'add_new_product'])->name('add_new_product');
Route::get('delete_specific_product/{id}', [ProductController::class,'delete_specific_product'])->name('delete_specific_product');
Route::get('update_existing_product/{id}', [ProductController::class,'update_existing_product'])->name('update_existing_product');
Route::post('update_and_save_existing_product', [ProductController::class,'update_and_save_existing_product'])->name('update_and_save_existing_product');


Route::get('logout', [UserAuthController::class,'logout']);


