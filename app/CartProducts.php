<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartProducts extends Model
{
    protected $fillable = [
        'cart_id', 'product_id'
    ];

    
}
