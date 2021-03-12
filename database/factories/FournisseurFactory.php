<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fournisseur;
use Faker\Generator as Faker;

$factory->define(Fournisseur::class, function (Faker $faker) {
    return [
        'etablissement' => $faker->word,
        'rccm' => $faker->word,
        'nif' => $faker->word,
        'description' => $faker->text,
        'user_id' => factory(\App\User::class),
    ];
});
