<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'value',
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'value' => 'decimal',
    ];

    public function getValueAttribute()
    {
        return $this->attributes['value'];
    }

    public function getNameAttribute()
    {
        return $this->attributes['name'];
    }


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = ($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'discount_id','id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class,'discount_id','id');
    }
}
