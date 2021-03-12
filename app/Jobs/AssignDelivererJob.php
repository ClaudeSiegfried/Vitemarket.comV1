<?php

namespace App\Jobs;

use App\Models\Commande;
use App\Models\Livraison;
use App\Models\Livreur;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class AssignDelivererJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $commande;

    /**
     * Create a new job instance.
     *
     * @param Commande $commande
     */
    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $Livreur = Livreur::query()->GetFirstDispoLivreur()->get()->first();

            if ($Livreur){

                $livraison = Livraison::create([]);

                $livraison->commande()->associate($this->commande);
                $livraison->livreur()->associate($Livreur);
                $livraison->save();

                $Livreur->dispo = false;

                $Livreur->save();
            }

            dd($livraison);
        }
        catch(Throwable $e) {
            dd(report($e));
        }

    }

    public function failed($exception)
    {
        dd($exception);
        self::dispatch()->delay(now()->addSeconds(10));
    }
}
