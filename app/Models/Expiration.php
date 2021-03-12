<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expiration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_de_peremption',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];


    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function scopeGetExpirationDate($query, $id)
    {
        return $query ->where('id',$id);
    }
}
