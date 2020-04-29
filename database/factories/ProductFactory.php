<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\Store;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'store_id' => factory(\App\Store::class),
        'product_name' => $faker->name,
        'price' => $faker->randomDigit,
        'description' => $faker->sentence,
    ];
});
