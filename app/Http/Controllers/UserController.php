<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User; 
use App\Store;
use App\Product;
use Config;
use App\Helpers\AppHelper as Helper;

use Illuminate\Support\Facades\Auth; 
class UserController extends Controller {


public function register(Request $request) 
{
    $user = User::create($this->validateUserRegister()); 
    $token =  $user->createToken('MyApp')-> accessToken; 
    $response['name'] = $user['name'];
    $response['email'] = $user['email'];
    $response['token'] = $token;
    return Helper::buildResponse($response,true,
    Config::get('constants.status_codes.success') );
}

public function login(Request $request)
{   
    if (auth()->attempt($this->validateUserLogin())) {
        $user = auth()->user();
        $store = $user->store;
        $store->products;
        $token = auth()->user()->createToken('TutsForWeb')->accessToken;
        $response['name'] = $user['name'];
        $response['email'] = $user['email'];
        $response['token'] = $token;
        $response['store'] = $store;
        return Helper::buildResponse($response,true,
        Config::get('constants.status_codes.success') );
    } else {
        throw new \App\Exceptions\FailedLoginException();
    }
}

public function show()
{
    $user = auth()->user();
    $user->store;
    $response['user'] = $user;
    return Helper::buildResponse($response,true,
    Config::get('constants.status_codes.success') );
}

protected function validateUserRegister()
{
    return request()->validate([
        'name' => ['unique:users,name','required'],
        'email' => ['unique:users,email','required','email'],
        'password' => ['required', 'min:8']
    ]); 
}

protected function validateUserLogin()
{
    return request()->validate([
        'email' => ['exists:users,email','required','email'],
        'password' => ['required']
    ]); 
}

}
