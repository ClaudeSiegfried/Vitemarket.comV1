<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /**
     * Photo constructor.
     * @param array $fillable
     */

    protected $fillable = [
        'libele',
        'path',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function getPathAttribute()
    {
        return $this->attributes['path'];
    }

    public function SaveOrUpdate(Request $request, string $id, Model $model, string $prefix)
    {

        if ($request->hasFile($id)) {

            if ($model->belongsTo(Photo::class)) {

                $path = $model->photo()->get()->pluck('path')->first();

                if ((!empty($path)) && ($model->photo()->exists())) {

                    if(!$this->deletePhoto($path)){

                        $model->photo()->dissociate($model->photo()->get()->first());
                    };
                }else{
                    $model->photo()->dissociate($model->photo()->get()->first());
                }

                $file = $request->file($id);

                if (!empty($prefix)) {

                    $filename = $prefix . time() . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs($prefix, $filename, 'images');

                    $this->path = $path;

                    $this->libele = '';

                    $this->save();

                }

                if ($model->photo()->associate($this)) {

                    $model->update();

                    return true;
                }
            }

        }

        return false;
    }

    public function deletePhoto($path)
    {

        //dd(Storage::disk('images')->exists($path));

        if (!Storage::disk('images')->exists($path)) {
            return false;
            //abort(404);
        }else{
            $file = Storage::disk('images')->delete($path);

            $response = Response::make($file, 200);

            return $response;
        }
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
