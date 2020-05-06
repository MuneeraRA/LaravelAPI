<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

// Needs Auth user  
Route::middleware('auth:api')->group(function () {
    Route::get('/user/profile', 'UserController@show');
    Route::get('/user/store', 'StoreController@showUserStore');
    Route::post('/user/store', 'StoreController@store');
    Route::put('/user/store', 'StoreController@update');
    Route::post('/store/products', 'ProductController@store');

});

Route::get('stores', 'StoreController@index');
Route::get('/stores/{store}', 'StoreController@show');

// Guest API
Route::get('/cart', 'CartController@create');
Route::get('/cart/add', 'CartController@add_product');
Route::get('/cart/{cart}', 'CartController@show');
Route::delete('/cart/{cart}', 'CartController@destroy');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
