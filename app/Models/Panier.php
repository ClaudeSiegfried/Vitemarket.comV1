<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'produit_id',
        'quantite_achete',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'produit_id' => 'integer',
    ];


    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function produit()
    {
        return $this->hasMany(Produit::class,'id','produit_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
