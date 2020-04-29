<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Cart extends Model
{
    protected $fillable = [
        'id'
    ];


    public function products(){
    return $this->belongsToMany('App\Product','cart_products','cart_id','product_id'); 
}


}
