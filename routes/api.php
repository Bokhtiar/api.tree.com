<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* API Routes */


Route::group(['prefix' => 'user'], function () {
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('register', [UserAuthController::class, 'register']);

    /* products */
    
});


Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::group(['middleware' =>  'adminPermission', 'prefix' => 'admin'], function () {

    Route::resource('category', CategoryController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);
    
    Route::resource('product', ProductController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);
    Route::get('/product/status/{id}', [ProductController::class, 'status']);

});