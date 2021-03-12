<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RunApi;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
/*    public function __construct()
    {
        $this->middleware('api');
    }*/

    public function newUser(Request $request){
        return (new RunApi)->register($request);
    }

    public function RegisterUser(Request $request){
        return (new RunApi)->login($request);
    }

    public function RegisterFirebaseUser(Request $request){
        return (new RunApi)->LoginFirebase($request);
    }
}
