<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix'=>'admin','middleware' =>['auth']],function(){
    // product 
    Route::get('/view/product',[App\Http\Controllers\Admin\Product\ProductController::class, 'view']);
    Route::get('/create/product',[App\Http\Controllers\Admin\Product\ProductController::class, 'create']);
    Route::post('/store/product',[App\Http\Controllers\Admin\Product\ProductController::class, 'store']);
    Route::get('/delete/product/{slug}',[App\Http\Controllers\Admin\Product\ProductController::class, 'delete']);
    Route::get('/edit/product/{slug}',[App\Http\Controllers\Admin\Product\ProductController::class, 'edit']);
    Route::post('/update/product/{slug}',[App\Http\Controllers\Admin\Product\ProductController::class, 'update']);
    Route::get('/search/product',[App\Http\Controllers\Admin\Product\ProductController::class, 'search']);
});