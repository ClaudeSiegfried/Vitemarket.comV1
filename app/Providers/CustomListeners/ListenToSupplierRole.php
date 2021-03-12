<?php

namespace App\Providers\CustomListeners;

use App\Providers\IsSupplier;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenToSupplierRole
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IsSupplier  $event
     * @return void
     */
    public function handle(IsSupplier $event)
    {
        //
    }
}
