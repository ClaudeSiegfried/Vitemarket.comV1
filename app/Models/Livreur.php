<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'dispo',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'dispo' => 'boolean',
    ];


    public function livraisons()
    {
        return $this->belongsToMany(Livraison::class);
    }

    public function setDispoAttribute($value){

        $this->attributes['dispo'] = $value;
    }

    public function getDispoAttribute(){

        return $this->attributes['dispo'];
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

    public function ScopeGetDispo($query, $livreur){
        if($res = $query->where('id', $livreur->id)->where('dispo',false)->get()){
            return false;
        }
        return true;
    }

    public function ScopeGetFirstDispoLivreur($query){
        $query->where('dispo',true)->get();
    }

}
