<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use App\Helpers\AppHelper as Helper;
use Config;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        return $carts;
    }

    public function show(Cart $cart)
    {   
        $cart = Cart::find($cart)->first();
        try 
        {
            $cart->products;
            $response['cart'] = $cart;
            return Helper::buildResponse($response,true,
            Config::get('constants.status_codes.success') );
        } catch (\Throwable $ex) 
        {
            throw new \App\Exceptions\NotFoundException();
        }
        
    }
    
    public function create()
    {
        $cart = new Cart();
        $cart->save();
        $response['message'] = 'Created succsesfuly';
        $response['cart_id'] = $cart['id'];
        return Helper::buildResponse($response,true,
        Config::get('constants.status_codes.success') );
    }

    public function add_product()
    {
        $this->validateProduct();
        $cart = Cart::where('id',request('cart_id'))->firstOrFail();
        $cart->products()->syncWithoutDetaching(request('product_id'));
        $cart->products;
        $response['cart'] = $cart;
        return Helper::buildResponse($response,true,
        Config::get('constants.status_codes.success') );
    }
    public function destroy(Cart $cart)
    {
        if($cart->delete()){
            $response['message'] = "Deleted";
            return Helper::buildResponse($response,true,
            Config::get('constants.status_codes.success') );
        } else {
        $response['message'] = "Error while deleting";
        return Helper::buildResponse($response,false,
        Config::get('constants.status_codes.bad_request') );}
    }

    protected function validateProduct()
    {
        return request()->validate([
            'product_id' => ['exists:products,id','required'],
            'cart_id' => ['exists:carts,id','required']
        ]); 
    }
    protected function requestResponse(String $cartId , bool $requestFlag )
    {
        return response()->json([
            'success' => $requestFlag,
            'cart_id' => $cartId ]);
    }
}
