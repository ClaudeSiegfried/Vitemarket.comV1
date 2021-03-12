<?php
/**
 * Created by IntelliJ IDEA.
 * User: PC
 * Date: 22/07/2020
 * Time: 05:18
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class RunApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'RunApi';
    }
}
