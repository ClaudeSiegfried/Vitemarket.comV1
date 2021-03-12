<?php

namespace App\Models;

use App\Services\StockManagement;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'localisation_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'localisation_id' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNameAttribute()
    {
        return StockManagement::getModelAttribute($this, 'name', 'user');
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

    public function commandes(){

        return $this->hasMany(Commande::class);
    }

    public function localisation()
    {
        return $this->belongsTo(Localisation::class);
    }
}
