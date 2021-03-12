<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class StockManagementFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Warehouse';
    }
}
