<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiquette extends Model
{
    protected $fillable = [
        'name','description', 'photo_id'
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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ($value);
    }

    public function getNameAttribute()
    {
        return $this->attributes['name'];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description'];
    }

    public function produit()
    {
        return $this->belongsToMany(Produit::class,'etiquette_produit');
    }

}
