<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Livreur;
use Faker\Generator as Faker;

$factory->define(Livreur::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class),
        'dispo' => $faker->boolean,
    ];
});
