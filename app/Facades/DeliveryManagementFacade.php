<?php
/**
 * Created by IntelliJ IDEA.
 * User: PC
 * Date: 19/09/2020
 * Time: 18:11
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class DeliveryManagementFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Delivery';
    }
}
