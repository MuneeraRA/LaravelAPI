<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Product;

class Store extends Model
{
    protected $fillable = [
        'store_name', 'user_id','id'
    ];

    public function user(){
    return $this->belongsTo(User::class);
    }

    public function products(){
    return $this->hasMany(Product::class);
    }

}
