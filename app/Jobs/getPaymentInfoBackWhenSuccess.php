<?php

namespace App\Jobs;

use App\Models\Commande;
use App\Models\Livraison;
use App\Models\Livreur;
use App\Models\paiement_info;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class getPaymentInfoBackWhenSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $request;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $R = $this->request;

        $newP = paiement_info::create([
            'tx_reference' => $R->tx_reference,
            'identifier' => $R->identifier,
            'payment_reference' => $R->payment_reference,
            'amount' => $R->amount,
            'datetime' => Carbon::parse($R->datetime),
            'payment_method' => $R->payment_method,
            'phone_number' => $R->phone_number,
        ]);

        $commande = Commande::query()->where('code_commande', '=', $R->identifier)->get()->first();

        $newP->commande()->associate($commande);

        $newP->save();

        $paiement = $commande->paiement()->get();

        foreach ($paiement as $p) {
            if ($p->montant == $R->amount) {
                $p->statut = "paid";
                $p->save();
            }
        }

        AssignDelivererJob::dispatchNow($commande);

    }

}
