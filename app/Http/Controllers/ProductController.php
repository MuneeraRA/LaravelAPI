<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Helpers\AppHelper as Helper;
use Config;

class ProductController extends Controller
{


    public function store(Request $request)
    {
        $user = auth()->user();
        $store = auth()->user()->store;
        if ($store){
            $product = new Product($this->validateProduct());
            $product['store_id'] = $store['id'];
            $product->save();
            $store->products;
            $response['store'] = $store;
            return Helper::buildResponse($response,true,
            Config::get('constants.status_codes.success') );
        } else {
            throw new \App\Exceptions\StoreNotFoundException();
        }
    }

    protected function validateProduct()
    {
        return request()->validate([
            'product_name' => ['required','max:120'],
            'price' => ['required','integer'],
            'description' => ['nullable']
        ]); 
    }
}
