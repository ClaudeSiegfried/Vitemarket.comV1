<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif_Livraison extends Model
{
    protected $fillable = [
        'couverture',
        'frais',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'frais' => 'double',
    ];

    protected $table = 'tarif_livraisons';

    public function getFraisAttribute()
    {
        return $this->attributes['frais'];
    }

    public function getCouvertureAttribute()
    {
        return $this->attributes['couverture'];
    }

    public function setFraisAttribute($value)
    {
        $this->attributes['frais'] = ($value);
    }

    public function setCouvertureAttribute($value)
    {
        $this->attributes['couverture'] = ($value);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
