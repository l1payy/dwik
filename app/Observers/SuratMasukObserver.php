<?php

namespace App\Observers;

use App\Models\SuratMasuk;
use App\Models\Notifikasi;
use App\Models\User;

class SuratMasukObserver
{
    /**
     * Handle the SuratMasuk "created" event.
     */
    public function created(SuratMasuk $suratMasuk): void
    {
        // Notify Sekretaris and Pimpinan
        $users = User::whereIn('role', ['sekretaris', 'pimpinan'])->get();

        foreach ($users as $user) {
            Notifikasi::create([
                'user_id' => $user->id,
                'tipe' => 'surat_masuk',
                'judul' => 'Surat Masuk Baru',
                'pesan' => "Ada surat masuk baru dari {$suratMasuk->pengirim} dengan perihal: {$suratMasuk->perihal}",
                'is_read' => false,
                'related_id' => $suratMasuk->id,
                'related_type' => get_class($suratMasuk),
            ]);
        }
    }
}
