<?php

namespace App\Jobs;

use App\Models\Commande;
use App\Models\paiement_info;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ManageTMoneyPaiementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url = 'https://paygateglobal.com/api/v1/pay';
    protected $token = '0f5e8bc3-3914-4479-969e-d092a83baa5b';
    protected $commande;
    protected $request;
    protected $user_id;
    protected $totalPanier;
    protected $mmoneyPArray;
    protected $phone_number;
    protected $code;

    /**
     * Create a new job instance.
     *
     * @param Commande $commande
     * @param Request $request
     */
    public function __construct(Commande $commande, Request $request)
    {
        $this->commande = $commande;
        $this->request = $request;
        $this->code = $commande->code_commande;
        $this->totalPanier = $request->total;

        $this->phone_number = $request->phone_number;

        $this->user_id = $request->user_id;

        $this->totalPanier = $request->total;

        $this->mmoneyPArray = $request->mmoney_id;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $commande = $this->commande;

        $newP = paiement_info::create([
            'tx_reference' => $this->code,
            'identifier' => $this->code,
            'payment_reference' => $this->code,
            'amount' => $this->totalPanier,
            'payment_method' => 'Espece',
            'phone_number' => $this->phone_number,
        ]);

        $newP->commande()->associate($commande);

        $newP->save();

        $paiement = $commande->paiement()->get();

        foreach ($paiement as $p) {
            $p->statut = "paid";
            $p->save();
        }
        /*if ($p->montant == $R->amount) {
            $p->statut = "paid";
            $p->save();
        }*/

    }
}
