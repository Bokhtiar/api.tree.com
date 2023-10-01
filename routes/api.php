<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
// Route::controller(AuthController::class)->group(function () {
//     Route::post('login', 'login');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');
// });


Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::group(['middleware' =>  'adminPermission', 'prefix' => 'admin'], function () {

    Route::resource('category', CategoryController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);
    
    Route::resource('product', ProductController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);

});