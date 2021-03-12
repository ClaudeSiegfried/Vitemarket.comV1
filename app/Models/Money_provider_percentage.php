<?php

namespace App\Models;

use App\Services\StockManagement;
use Illuminate\Database\Eloquent\Model;

class Money_provider_percentage extends Model
{
    protected $fillable = [
        'percentage',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mmoney_id' => 'integer',
        'percentage' => 'integer',
    ];

    public function getPercentageAttribute()
    {
        return $this->attributes['percentage'];
    }

    public function getProviderAttribute()
    {
        return StockManagement::getModelAttribute($this, 'fam', 'mmoney');
    }

    public function setPercentageAttribute($value)
    {
        $this->attributes['percentage'] = strtolower($value);
    }

    public function mmoney()
    {
        return $this->belongsTo(Mmoney::class);
    }
}
