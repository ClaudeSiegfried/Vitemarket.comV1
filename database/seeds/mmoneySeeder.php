<?php

use Illuminate\Database\Seeder;
use App\Models\Mmoney;

class mmoneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $TMONEY = Mmoney::create([
            'fam' => 'Tmoney',
            'credential' => 'Paiement via Tmoney',
        ]);

        $FLOOZ = Mmoney::create([
            'fam' => 'Flooz',
            'credential' => 'Paiement via Flooz',
        ]);

        $ESPECE = Mmoney::create([
            'fam' => 'Espece',
            'credential' => 'Paiement en espece ',
        ]);

    }
}
