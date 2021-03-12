<?php

namespace App\Http\Controllers\Configurations;

use App\Http\Controllers\Controller;
use App\Services\RunApi;
use App\Services\StockManagement;
use Illuminate\Http\Request;
use Throwable;

class TokenController extends Controller
{
    public function index(){
        try {
            return StockManagement::getToken() ;
        } catch (Throwable $e) {

            return report($e);
        }
    }

    public function fcm(Request $request){
        return RunApi::SaveFcmToken($request) ;
    }

}
