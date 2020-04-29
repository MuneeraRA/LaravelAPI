<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CartProducts;
use App\Cart;
use App\Product;

use Faker\Generator as Faker;

$factory->define(CartProducts::class, function (Faker $faker) {
    return [
        'cart_id' => factory(\App\Cart::class),
        'product_id' => factory(\App\Product::class),
    ];
});
