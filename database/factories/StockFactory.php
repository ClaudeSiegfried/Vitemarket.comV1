<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'produit_id' => factory(\App\Produit::class),
        'quantite_physique' => $faker->randomNumber(),
        'quantite_predebite' => $faker->randomNumber(),
        'quantite_facture' => $faker->randomNumber(),
        'expiration_id' => factory(\App\Expiration::class),
    ];
});
