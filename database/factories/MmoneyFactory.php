<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Mmoney;
use Faker\Generator as Faker;

$factory->define(Mmoney::class, function (Faker $faker) {
    return [
        'fam' => $faker->word,
        'credential' => $faker->word,
    ];
});
