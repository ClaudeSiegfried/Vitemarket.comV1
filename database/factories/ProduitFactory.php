<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produit;
use Faker\Generator as Faker;

$factory->define(Produit::class, function (Faker $faker) {
    return [
        'Libele' => $faker->word,
        'description' => $faker->text,
        'taille' => $faker->randomFloat(2, 0, 999999.99),
        'poids' => $faker->randomFloat(2, 0, 999999.99),
        'prix' => $faker->randomFloat(0, 0, 9999999999.),
        'code_gen' => $faker->word,
        'date_de_creation' => $faker->date(),
        'categorie_id' => factory(\App\Categorie::class),
        'marque_id' => factory(\App\Marque::class),
        'fournisseur_id' => factory(\App\Fournisseur::class),
        'photo_id' => factory(\App\Photo::class),
    ];
});
