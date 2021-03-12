<?php

namespace App\Jobs;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;


class AskPaygateFloozJob implements ShouldQueue
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
        if (isset($request->phone_number)) {
            $this->phone_number = $request->phone_number;
        }
        if (isset($request->user_id)) {
            $this->user_id = $request->user_id;
        }
        if (!empty($request->total)) {
            $this->totalPanier = $request->total;
        }
        if (isset($request->mmoney_id)) {
            $this->mmoneyPArray = $request->mmoney_id;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->user_id)->get()->first();

        if(isset($this->phone_number)){
            $req = [
                'auth_token' => $this->token,
                'phone_number' => ($this->phone_number),
                'amount' => $this->totalPanier,
                'description' => 'Achat',
                'identifier' => $this->code,
            ];
        }else{
            $req = [
                'auth_token' => $this->token,
                'phone_number' => ($user->tel),
                'amount' => $this->totalPanier,
                'description' => 'Achat',
                'identifier' => $this->code,
            ];
        }
        //dd($req);

        $response = Http::withoutVerifying()->retry(3, 1000)->post($this->url, $req);

        if ($response->successful()){
            if($response->object()->status === 0){
                //dd($response);
            };
        }
    }
}
