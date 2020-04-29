<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use App\CartProducts;
class GuestController extends Controller
{
    public $successStatus = 200;
    public $failerStatus = 401;

    public function create_cart(){
        $cart = Cart::create();
        $response['cart_id'] = $cart['id'];
        return response()->json([
            'success' => true,
            'message' => 'Cart Created Succesfuly',
            'response' => $response
        ] , $this->successStatus); 
    }

    public function add_product(Request $request){
        $cart['cart_id'] = $request['cart_id'];
        $cart['product_id'] = $request['product_id'];

        if (!Cart::find($request['cart_id']))
            return response()->json([
                'success' => false,
                'error' => 'Cart with id'. $request['cart_id'] .' not found'
            ], $this->failerStatus);
        
        if (!Product::find($request['product_id']))
        return response()->json([
            'success' => false,
            'error' => 'Product with id '. $request['product_id'] .' not found'
        ], $this->failerStatus);

        $cart = CartProducts::create($cart);
        

        if (!$cart) {
            return response()->json([
                'success' => false,
                'error' => 'Un-able to add products'
            ], $this->failerStatus);
        } else{
        $cart = Cart::find($request['cart_id']);
        $cart->products;
        $response['cart'] = $cart;
        return response()->json([
            'success' => true,
            'message' => 'Product Added Succesfuly',
            'response' => $response,
        ] , $this->successStatus); }
    }

    public function view_cart(Request $request){
        $cart = Cart::find($request['cart_id']);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'error' => 'Cart with id ' . $request['cart_id'] . ' not found'
            ], $this->failerStatus);
        } else{
            $cart->products;
            $response['cart'] = $cart;
            return response()->json([
                'success' => true,
                'response' => $response,
            ] , $this->successStatus);
        }
    }

}
