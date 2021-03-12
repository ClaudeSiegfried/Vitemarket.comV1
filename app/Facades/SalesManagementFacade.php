<?php
/**
 * Created by IntelliJ IDEA.
 * User: PC
 * Date: 19/09/2020
 * Time: 17:08
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class SalesManagementFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Sales';
    }
}
