<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comite;
use Faker\Generator as Faker;

$factory->define(Comite::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
    ];
});
