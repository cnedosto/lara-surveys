<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClearTenantIdFromSession
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        session()->forget('tenant_id');
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
    }
}
