<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Localisation;
use Faker\Generator as Faker;

$factory->define(Localisation::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class),
        'photo_id' => factory(\App\Photo::class),
        'description' => $faker->text,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
    ];
});
