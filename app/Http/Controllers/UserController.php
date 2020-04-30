<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User; 
use App\Store;
use App\Product;
use Illuminate\Support\Facades\Auth; 
class UserController extends Controller {

public $successStatus = 200;
public $badRequestStatus = 401;
public $permissionsErrorStatus = 403;

public function register(Request $request) {
    $validator = Validator::make($request->all(), [ 
        'name' => 'required',
        'email' => 'required|email', 
        'password' => 'required', ]);
    if ($validator->fails()) { 
        $fail['error'] = $validator->errors();
        $fail['success'] = false;
        return response()->json($fail, $this-> badRequestStatus);}
    if ($user = User::where('name', $request['name'])->first())
        return response()->json([
            'success' => false,
            'error' => 'User with name '. $request['name'] .' is already registered'
        ], $this-> badRequestStatus);
    if ($user = User::where('email', $request['email'])->first())
        return response()->json([
            'success' => false,
            'error' => 'User with email '. $request['email'] .' is already registered'
        ], $this-> badRequestStatus);
    $input['name'] = $request['name'];
    $input['email'] = $request['email'];
    $input['password'] = bcrypt($request['password']); 
    $user = User::create($input); 
    $new_store['user_id'] = $user['id'];
    $new_store['store_name'] = $user['name'];
    $store = Store::create($new_store);
    $token =  $user->createToken('MyApp')-> accessToken; 
    $response['name'] = $user['name'];
    $response['email'] = $user['email'];
    $response['token'] = $token;
    return response()->json([
    'success' => true,
    'response' => $response
    ], $this-> successStatus); 
}

/**
 * Handles Login Request
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
public function login(Request $request)
{   
    $validator = Validator::make($request->all(), [ 
        'email' => 'required|email', 
        'password' => 'required', 
    ]);
    if ($validator->fails()) { 
            $fail['error'] = $validator->errors();
            $fail['success'] = false;
            return response()->json($fail, 401);            
    }

    $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];

    if (auth()->attempt($credentials)) {
        $user = auth()->user();
        $store = $user->store;
        $store->products;
        $token = auth()->user()->createToken('TutsForWeb')->accessToken;
        $response['name'] = $user['name'];
        $response['email'] = $user['email'];
        $response['token'] = $token;
        $response['store'] = $store;
        return response()->json([
        'success' => true,
        'response' => $response
        ], $this-> successStatus);
    } else {
        return response()->json([
            'success' => false,
            'error' => 'Un-Authorised'], $this->badRequestStatus);
    }
}

/**
 * Returns Authenticated User Details
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function details(){
    return response()->json([
        'success' => true,
        'user' => auth()->user()], $this->badRequestStatus);}

public function store(){
    $store = auth()->user()->store;
    return response()->json([
        'success' => true,
        'data' => $store
    ]);
}

public function add_product(Request $request){
    $user = auth()->user();
    $store = auth()->user()->store;
    if (!$store) {
        return response()->json([
            'success' => false,
            'error' => 'Store with id ' . $user['id'] . ' not found'
        ], $this-> badRequestStatus);
    } else{

        $validator = Validator::make($request->all(), [ 
            'product_name' => 'required', 
            'price' => 'required', 
        ]);
        if ($validator->fails()) { 
            $fail['error'] = $validator->errors();
            $fail['success'] = false;
            return response()->json($fail, $this->badRequestStatus); }

        $product['store_id'] = $store['id'];
        $product['product_name'] = $request['product_name'];
        $product['description'] = $request['description'];
        $product['price'] = (float) $request['price'];
        $product = Product::create($product);
        $store->products;
        $response['store'] = $store;
        return response()->json([
            'success' => true,
            'message' => 'Product added Succesfuly',
            'response' => $response
        ] , $this->successStatus);

    }
}

public function products(){
    $store = auth()->user()->store;
    $store->products;

    if (!$store) {
        return response()->json([
            'success' => false,
            'error' => 'Store with id ' . $user['id'] . ' not found'
        ], $this->badRequestStatus);
    } else{
        $response['store'] = $store;
        return response()->json([
            'success' => true,
            'response' => $response
        ] , $this->badRequestStatus);

    }
}

}
