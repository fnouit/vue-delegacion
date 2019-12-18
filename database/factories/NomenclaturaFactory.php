<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nomenclatura;
use Faker\Generator as Faker;

$factory->define(Nomenclatura::class, function (Faker $faker) {
    return [
        'nomenclatura' => $faker->name,
    ];
});
