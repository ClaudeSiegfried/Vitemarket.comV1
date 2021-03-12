<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Paiement;
use Faker\Generator as Faker;

$factory->define(Paiement::class, function (Faker $faker) {
    return [
        'commande_id' => factory(\App\Commande::class),
        'client_id' => factory(\App\Client::class),
        'mmoney_id' => factory(\App\Mmoney::class),
        'statut' => $faker->randomElement(["paid","pending","liquide"]),
        'montant' => $faker->randomFloat(0, 0, 9999999999.),
    ];
});
