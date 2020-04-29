<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class StoreController extends Controller
{
    

    public function index()
    {
        $store = auth()->user()->store();
 
        return response()->json([
            'success' => true,
            'data' => $store
        ]);
    }

}
