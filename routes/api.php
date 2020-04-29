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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'UserController@details');
    Route::get('store', 'UserController@store');
    Route::get('products', 'UserController@products');
    Route::post('add', 'UserController@add_product');
    // Route::resource('products', 'ProductController');
});

// Guest API
Route::get('new_cart', 'GuestController@create_cart');
Route::get('add_product', 'GuestController@add_product');
Route::get('view_cart', 'GuestController@view_cart');


