<?php

namespace App\Http\Controllers\Configurations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RunApi;

class OtpController extends Controller
{
    public function Send(Request $request){
        return RunApi::GetOtp($request);
    }
}
