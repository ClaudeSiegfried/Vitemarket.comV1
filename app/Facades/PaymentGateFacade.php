<?php
/**
 * Created by IntelliJ IDEA.
 * User: PC
 * Date: 17/09/2020
 * Time: 19:37
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class PaymentGateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PaymentGate';
    }
}
