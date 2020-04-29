<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Store;
use App\User;
use Faker\Generator as Faker;

$factory->define(Store::class, function (Faker $faker) {
    return [
        
        'user_id' => factory(\App\User::class),
        'store_name' => $faker->sentence(),
        
    ];
});
