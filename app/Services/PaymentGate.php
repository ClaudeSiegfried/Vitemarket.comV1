<?php
/**
 * Created by IntelliJ IDEA.
 * User: PC
 * Date: 17/09/2020
 * Time: 19:35
 */

namespace App\Services;


use App\Models\Commande;
use App\Models\paiement_info;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

use App\Jobs\getPaymentInfoBackWhenSuccess;

class PaymentGate
{
    public static function PayGateCallBack(Request $request){

        $rules = [
            'tx_reference' => 'required',
            'identifier' => 'required',
            'payment_reference' => 'required',
            'amount' => 'required',
            'datetime' => 'required',
            'payment_method' => 'required',
            'phone_number' => 'required'
        ];

            $validator = $request->validate($rules,$request->all());

            if ($validator) {
                if ($request->expectsJson()) {
                    getPaymentInfoBackWhenSuccess::dispatchAfterResponse($request);
                }
                return true;
            }
        return false;
    }
}
