<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'tel', 'metier', 'date_de_naissance', 'photo_id', 'active', 'verified', 'uid','fcm', 'discount_id'
    ];


    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'uid','fcm',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function via($notifiable)
    {
        return $notifiable->prefers_sms ? ['nexmo'] : ['mail', 'database'];
    }

    public function routeNotificationForNexmo($notification)
    {
        return $this->tel;

    }

    public function routeNotificationForMail($notification)
    {
        return $this->email;

    }

    public function routeNotificationForFcm()
    {
        return $this->fcm;
    }

    public function getImageAttribute()
    {
        if ($this->photo()->exists()){
            $photo =  $this->photo()->first();
            return url(route('photo.display',$photo->path));
        }
        return asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png');

    }

    public function updateUser(Request $request, User $user)
    {

        $Photo = new Photo();

        $user->roles()->sync($request->role);

        if ($user->update()) {

            $user->roles()->sync($request->role);

            $id = $user->id;

            if ($user->hasRole('fournisseur')) {
                // dd('here');
                $user->suppliers()->updateOrCreate(['user_id' => $id]);
            } else {
                if ($user->suppliers()->exists()) {
                    $user->suppliers()->delete();
                };
            }

            if ($user->hasRole('livreur')) {
                $user->deliverers()->updateOrCreate(['user_id' => $id]);
            } else {
                if ($user->deliverers()->exists()) {
                    $user->deliverers()->delete();
                }
            }

            if ($user->hasRole('client')) {
                $user->clients()->updateOrCreate(['user_id' => $id]);
            } else {
                if ($user->clients()->exists()) {
                    $user->clients()->delete();
                }
            }

        } else {
            $request->session()->flash('error', 'User was not updated');
        };

        $Photo->SaveOrUpdate($request, 'photo_id', $user, 'user');

        if ($user->update($request->except(['role', 'photo_id',]))) {
            return true;
        } else {
            return false;
        }
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function clients()
    {
        return $this->hasOne(Client::class);
    }

    public function suppliers()
    {
        return $this->hasOne(Fournisseur::class);
    }

    public function deliverers()
    {
        return $this->hasOne(Livreur::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }

        return false;
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }

        return false;
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function localisation()
    {
        return $this->hasMany(
            Localisation::class,
            'user_id',
            'id'
        );
    }

    public function scopeWhereUid($query, $uid){
        return $query->where('uid','=',$uid);
    }

    public function getIdAttribute(){
        return $this->attributes['id'];
    }

    public function getFcmAttribute(){
        return $this->attributes['fcm'];
    }

    public function setFcmAttribute($value)
    {
        $this->attributes['fcm'] = ($value);
    }

}
