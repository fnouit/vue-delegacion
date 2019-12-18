<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Region;
use Faker\Generator as Faker;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'nombre' => $faker->city,
        'sede' => $faker->city,
        'coordinador' => $faker->name, 
    ];
});
