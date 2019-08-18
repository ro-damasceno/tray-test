<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Seller;
use Faker\Generator as Faker;

$factory->define(Seller::class, function (Faker $faker) {

	return [
		'name'  => $faker->name,
		'email' => $faker->unique()->safeEmail,
    ];
});
