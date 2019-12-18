<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nivel;
use Faker\Generator as Faker;

$factory->define(Nivel::class, function (Faker $faker) {
    return [
        'nivel_educativo' => $faker->name,
    ];
});
