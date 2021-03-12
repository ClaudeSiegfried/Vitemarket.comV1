<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Livraison;
use Faker\Generator as Faker;

$factory->define(Livraison::class, function (Faker $faker) {
    return [
        'commande_id' => factory(\App\Commande::class),
        'livreur_id' => factory(\App\Livreur::class),
        'statut' => $faker->randomElement(["pending","successful","failed"]),
    ];
});
