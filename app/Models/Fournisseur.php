<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Fournisseur extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'etablissement',
        'rccm',
        'nif',
        'description',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];


    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function photo(){
        return $this->hasOneThrough(
            Photo::class,
            User::class,
            'id',
            'id',
            'id',
            'photo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
