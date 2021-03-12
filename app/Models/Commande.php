<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'panier_id',
        'client_id',
        'localisation_id',
        'code_commande',
        'date_livraison',
        'statut',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'panier_id' => 'integer',
        'client_id' => 'integer',
        'localisation_id' => 'integer',
    ];

    public function getCodeCommandeAttribute()
    {
        return $this->attributes['code_commande'];
    }


    public function paiement()
    {
        return $this->belongsTo(Paiement::class,'id','commande_id');
    }

    public function livraison()
    {
        return $this->hasOne(Livraison::class);
    }

    public function panier()
    {
        return $this->belongsTo(Panier::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function localisation()
    {
        return $this->belongsTo(Localisation::class,'localisation_id','id');
    }
}
