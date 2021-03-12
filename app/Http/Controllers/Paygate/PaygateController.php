<?php

namespace App\Http\Controllers\Paygate;

use App\Http\Controllers\Controller;
use App\Services\PaymentGate;
use Illuminate\Http\Request;

class PaygateController extends Controller
{

    public function get(Request $request){
         return PaymentGate::PayGateCallBack($request);
    }
}
