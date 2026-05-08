<?php

namespace App\Observers;

use App\Models\Disposisi;
use App\Models\Notifikasi;

class DisposisiObserver
{
    /**
     * Handle the Disposisi "created" event.
     */
    public function created(Disposisi $disposisi): void
    {
        // Notify the recipient (kepada_user_id)
        Notifikasi::create([
            'user_id' => $disposisi->kepada_user_id,
            'tipe' => 'disposisi',
            'judul' => 'Disposisi Baru',
            'pesan' => "Anda menerima disposisi baru dari {$disposisi->pengirim->name} untuk surat: {$disposisi->suratMasuk->no_surat}",
            'is_read' => false,
            'related_id' => $disposisi->id,
            'related_type' => get_class($disposisi),
        ]);
    }

    /**
     * Handle the Disposisi "updated" event.
     */
    public function updated(Disposisi $disposisi): void
    {
        if ($disposisi->isDirty('kepada_user_id')) {
            Notifikasi::create([
                'user_id' => $disposisi->kepada_user_id,
                'tipe' => 'disposisi',
                'judul' => 'Update Disposisi',
                'pesan' => "Disposisi untuk surat {$disposisi->suratMasuk->no_surat} telah dialihkan kepada Anda.",
                'is_read' => false,
                'related_id' => $disposisi->id,
                'related_type' => get_class($disposisi),
            ]);
        }
    }
}
