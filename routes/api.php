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
    Route::get('/users/profile', 'UserController@show');
    Route::get('/users/store', 'StoreController@showUserStore');
    Route::post('/users/store', 'StoreController@store');
    Route::put('/users/store', 'StoreController@update');
    Route::post('/stores/products', 'ProductController@store');

});
// Guest API
Route::get('stores', 'StoreController@index');
Route::get('/stores/{store}/products', 'StoreController@show');
Route::get('/cart', 'CartController@create');
Route::get('/carts/add', 'CartController@add_product');
Route::get('/carts/{cart}', 'CartController@show');
Route::delete('/carts/{cart}', 'CartController@destroy');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
