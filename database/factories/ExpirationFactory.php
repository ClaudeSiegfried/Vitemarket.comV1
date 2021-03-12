<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expiration;
use Faker\Generator as Faker;

$factory->define(Expiration::class, function (Faker $faker) {
    return [
        'date_de_peremption' => $faker->date(),
    ];
});
