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
   // category
   Route::get('/view/category',[App\Http\Controllers\Admin\Category\CategoryController::class, 'view']);
   Route::get('/create/category',[App\Http\Controllers\Admin\Category\CategoryController::class, 'create']);
   Route::post('/store/category',[App\Http\Controllers\Admin\Category\CategoryController::class, 'store']);
   Route::get('/delete/category/{slug}',[App\Http\Controllers\Admin\Category\CategoryController::class, 'delete']);
   Route::get('/edit/category/{slug}',[App\Http\Controllers\Admin\Category\CategoryController::class, 'edit']);
   Route::post('/update/category/{id}',[App\Http\Controllers\Admin\Category\CategoryController::class, 'update']);
   Route::get('/search/category',[App\Http\Controllers\Admin\Category\CategoryController::class, 'search']);
  // user
  Route::get('/view/user',[App\Http\Controllers\Admin\User\UserController::class, 'view']);
  Route::get('/delete/user/{slug}',[App\Http\Controllers\Admin\User\UserController::class, 'delete']);
  Route::get('/edit/user/{slug}',[App\Http\Controllers\Admin\User\UserController::class, 'edit']);
  Route::post('/update/user/{slug}',[App\Http\Controllers\Admin\User\UserController::class, 'update']);
  Route::get('/search/user',[App\Http\Controllers\Admin\User\UserController::class, 'search']);
   // region
   Route::get('/view/region',[App\Http\Controllers\Admin\Region\RegionController::class, 'view']);
   Route::get('/create/region',[App\Http\Controllers\Admin\Region\RegionController::class, 'create']);
   Route::post('/store/region',[App\Http\Controllers\Admin\Region\RegionController::class, 'store']);
   Route::get('/delete/region/{slug}',[App\Http\Controllers\Admin\Region\RegionController::class, 'delete']);
   Route::get('/edit/region/{slug}',[App\Http\Controllers\Admin\Region\RegionController::class, 'edit']);
   Route::post('/update/region/{slug}',[App\Http\Controllers\Admin\Region\RegionController::class, 'update']);
   Route::get('/search/region',[App\Http\Controllers\Admin\Region\RegionController::class, 'search']);
  //  Contact
  Route::get('/create/contact',[App\Http\Controllers\contact\ContactController::class,'add']);
  Route::get('/view/contact',[App\Http\Controllers\Admin\Contact\ContactController::class, 'view']);

});
