<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    return [
    	'total'   	=> $faker->randomFloat (2, 30, 10000),
		'seller_id' => function () {
			return \App\Models\Seller::query ()->inRandomOrder ()->first()->getKey ();
		}
	];
});
