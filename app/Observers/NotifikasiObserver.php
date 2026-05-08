<?php

namespace App\Observers;

use App\Models\Notifikasi;
use App\Events\NotifikasiSent;

class NotifikasiObserver
{
    /**
     * Handle the Notifikasi "created" event.
     */
    public function created(Notifikasi $notifikasi): void
    {
        event(new NotifikasiSent($notifikasi));
    }
}
