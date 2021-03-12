<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Panier;
use Faker\Generator as Faker;

$factory->define(Panier::class, function (Faker $faker) {
    return [
        'produit_id' => factory(\App\Produit::class),
        'quantite_achete' => $faker->randomNumber(),
    ];
});
