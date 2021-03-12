<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mmoney extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fam',
        'credential',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function getFamAttribute()
    {
        return $this->attributes['fam'];
    }

    public function getProviderPercentageAttribute()
    {
        if ($this->percentage()->exists()){
            $p = $this->percentage()->first();
            return $p->percentage;
        }
        return 0;
    }

    public function paiements()
    {
        return $this->belongsToMany(Paiement::class);
    }

    public function hasMmoney($mmoney){

        if ($this->query()->where('fam',$mmoney)->first()){
            return true;
        }
        return false;
    }

    public function percentage(){
        return $this->hasOne(Money_provider_percentage::class);
    }

}
