<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Commande;
use Faker\Generator as Faker;

$factory->define(Commande::class, function (Faker $faker) {
    return [
        'panier_id' => factory(\App\Panier::class),
        'client_id' => factory(\App\Client::class),
        'localisation_id' => factory(\App\Localisation::class),
        'code_commande' => $faker->word,
        'date_livraison' => $faker->date(),
        'statut' => $faker->randomElement(["pending","successful","failed"]),
    ];
});
