<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libele',
        'description',
        'photo_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'photo_id' => 'integer',
    ];


    public function produits()
    {
        return $this->hasMany(Produit::class,'categorie_id','id');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
