<?php

namespace App\Models;

use App\Services\StockManagement;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commande_id',
        'client_id',
        'mmoney_id',
        'statut',
        'montant',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'commande_id' => 'integer',
        'client_id' => 'integer',
        'mmoney_id' => 'integer',
        'montant' => 'decimal',
    ];

    public function getMontantAttribute()
    {
        return $this->attributes['montant'];
    }

    public function getProviderAttribute()
    {
        return StockManagement::getModelAttribute($this, 'fam', 'mmoney');
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = strtolower($value);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function paiement_info()
    {
        return $this->belongsTo(paiement_info::class,'commande_id','commande_id');
    }

    public function mmoney()
    {
        return $this->belongsToMany(Mmoney::class);
    }

    public function hasMmoney($mmoney){

        if ($this->mmoney()->where('fam',$mmoney)->first()){
            return true;
        }
        return false;
    }

    public function scopeGetCommandeWithId($query, $id){

        return ($query->from('paiements')->where('commande_id','=',$id));
    }
}
