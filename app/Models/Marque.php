<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libele',
        'description',
    ];


    public function produits()
    {
        return $this->belongsToMany(Produit::class);
    }
}
