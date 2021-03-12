<?php

namespace App\Jobs;

use App\Models\Commande;
use App\Models\Mmoney;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPaiementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commande;
    protected $request;
    protected $user_id;
    protected $totalPanier;
    protected $mmoneyPArray;


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
        $RP = $this->request;
        $CP = $this->commande;
        $user = User::find($this->user_id)->get()->first();
        $Pprovider = json_decode($this->mmoneyPArray);

        $pay = Paiement::create([
            'montant' => $this->totalPanier
        ]);

        $pay->commande()->associate($this->commande);
        $pay->client()->associate($user->clients()->get()->first());
        $pay->mmoney()->sync($Pprovider);
        $pay->save();

        //dd($pay);
        //dd($CP);

        foreach ($Pprovider as $p) {

            $temp = Mmoney::find(((int)($p)));

            if ($temp->hasMmoney('Flooz')) {
                AskPaygateFloozJob::dispatchNow($CP, $RP);
            }
            if ($temp->hasMmoney('Espece')) {
                ManageLiquidePaiementJob::dispatchNow($CP,$RP);
            }
        }
    }

    /**
     * @return Paiement
     *
     */
    public function getPaiement(): Commande
    {
        return $this->commande;
    }
}
