<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Secretaria;
use Faker\Generator as Faker;

$factory->define(Secretaria::class, function (Faker $faker) {
    return [
        'cartera' => $faker->name,
        'comite_id' => $faker->buildingNumber,
    ];
});
