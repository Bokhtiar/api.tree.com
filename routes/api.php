<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\ProductController as UserProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* API Routes */

Route::post('login', [UserAuthController::class, 'login']);
Route::post('register', [UserAuthController::class, 'register']);

/** products */
Route::get('products', [UserProductController::class, 'index']);
Route::get('product/{id}', [UserProductController::class, 'show']);

/** category */
Route::get('categories', [UserCategoryController::class, 'index']);
Route::get('category/product/{id}', [UserCategoryController::class, 'categoryAssignProduct']);

/** filter search */
Route::post('product/price/filter', [UserProductController::class, 'priceFilter']);
Route::post('product/serach', [UserProductController::class, 'search']);
 
/** authorize user */
Route::group(['prefix' => 'user'], function () {
});


Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::group(['middleware' =>  'adminPermission', 'prefix' => 'admin'], function () {
    
    Route::get('/category/parent', [CategoryController::class, 'categoryParentList']);
    Route::resource('category', CategoryController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);
    
    
    Route::resource('product', ProductController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);
    Route::get('/product/status/{id}', [ProductController::class, 'status']);

});