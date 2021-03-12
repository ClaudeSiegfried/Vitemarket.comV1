<?php

namespace App\Http\Controllers\GestionPhotos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class PhotoController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard. 
     *
     * @param $filename
     * @return \Illuminate\Http\Response
     */
    public function display($filename)

    {
        $path = storage_path('images/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);

        $type = File::mimeType($path);


        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;

    }

    public function destroy($filename)
    {
        $path = storage_path('images/' . $filename);

        dd($path);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::delete($path);

        $response = Response::make($file, 200);

        return $response;
    }
}
