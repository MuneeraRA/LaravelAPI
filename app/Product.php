<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';


    protected $fillable = [
        'product_name', 'store_id','price', 'description'
    ];


}
