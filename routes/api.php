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
    Route::get('/user/profile', 'UserController@details');
    Route::get('/user/store', 'UserController@store');
    Route::get('/user/store/products', 'UserController@products');
    Route::post('/user/store/add_product', 'UserController@add_product');
});

// Guest API
Route::get('/guest/new_cart', 'GuestController@create_cart');
Route::get('/guest/add_product', 'GuestController@add_product');
Route::get('/guest/view_cart', 'GuestController@view_cart');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
