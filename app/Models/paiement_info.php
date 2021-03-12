<?php

namespace App\Models ;

use Illuminate\Database\Eloquent\Model;

class paiement_info extends Model
{
    protected $fillable = [
        'tx_reference',
        'commande_id',
        'identifier',
        'payment_reference',
        'amount',
        'datetime',
        'payment_method',
        'phone_number',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'commande_id' => 'integer',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

}
