<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Store;
use App\Product;
use Illuminate\Support\Facades\Auth; 
use App\Helpers\AppHelper as Helper;
use Config;

class StoreController extends Controller
{
    public function index(){
        $stores = Store::latest()->get();
        return Helper::buildResponse($stores,true,
        Config::get('constants.status_codes.success') );
    }

    public function showUserStore(){
        $store = auth()->user()->store;
        if ($store){
        $store->user;
        $store->products;
        return Helper::buildResponse($store,true,
        Config::get('constants.status_codes.success') );}
        else{
            throw new \App\Exceptions\StoreNotFoundException();
        }
    }

    public function show($store) 
    {
        try 
        {
            $store = Store::find($store)->first();
            $store->user;
            $store->products;
            return Helper::buildResponse($store,true,
            Config::get('constants.status_codes.success') );
        } catch (\Throwable $ex) {
            throw new \App\Exceptions\StoreNotFoundException();
        }
    }

    public function store(){
        $store = new Store($this->validateStore());
        $store->user_id = auth()->user()->id;
        $store->save();
        $response['message'] = 'Added succsesfuly';
        return Helper::buildResponse($response,true,
        Config::get('constants.status_codes.success') );
    }

     public function update(){
        $store = Store::where('user_id',auth()->user()->id)->first();
        if ($store){
        $this->validateStore();
        $store->store_name = request('store_name');
        $store->save();
        $response['message'] = 'Updated succsesfuly';
        return Helper::buildResponse($response,true,
        Config::get('constants.status_codes.success') );
        } else {
            throw new \App\Exceptions\StoreNotFoundException();
        }
     }


    protected function validateStore(){
    return request()->validate([
        'store_name' => ['required', 'min:3','max:150','unique:stores,store_name'],
    ]);}

    protected function requestResponse(String $message , bool $requestFlag ){
        return response()->json([
            'success' => $requestFlag,
            'message' => $message ]);
    }
}
