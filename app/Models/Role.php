<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function ScopeGetidbyrole($query, $role){
        return $query->where('name','=', $role)->get();
    }
}
