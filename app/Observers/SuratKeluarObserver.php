<?php

namespace App\Observers;

use App\Models\SuratKeluar;
use App\Models\Notifikasi;
use App\Models\User;

class SuratKeluarObserver
{
    /**
     * Handle the SuratKeluar "created" event.
     */
    public function created(SuratKeluar $suratKeluar): void
    {
        // Notify Sekretaris and Pimpinan
        $users = User::whereIn('role', ['sekretaris', 'pimpinan'])->get();

        foreach ($users as $user) {
            Notifikasi::create([
                'user_id' => $user->id,
                'tipe' => 'surat_keluar',
                'judul' => 'Surat Keluar Baru',
                'pesan' => "Ada surat keluar baru ditujukan ke {$suratKeluar->penerima} dengan perihal: {$suratKeluar->perihal}",
                'is_read' => false,
                'related_id' => $suratKeluar->id,
                'related_type' => get_class($suratKeluar),
            ]);
        }
    }

    /**
     * Handle the SuratKeluar "updated" event.
     */
    public function updated(SuratKeluar $suratKeluar): void
    {
        if ($suratKeluar->isDirty('status')) {
            $newStatus = $suratKeluar->status;
            
            // Notify creator when status changes
            Notifikasi::create([
                'user_id' => $suratKeluar->created_by,
                'tipe' => 'surat_keluar',
                'judul' => 'Update Status Surat Keluar',
                'pesan' => "Surat Keluar #{$suratKeluar->no_surat} sekarang berstatus: " . ucfirst(str_replace('_', ' ', $newStatus)),
                'is_read' => false,
                'related_id' => $suratKeluar->id,
                'related_type' => get_class($suratKeluar),
            ]);

            // Notify Pimpinan if status is 'menunggu_persetujuan'
            if ($newStatus == 'menunggu_persetujuan') {
                $pimpinan = User::where('role', 'pimpinan')->get();
                foreach ($pimpinan as $user) {
                    Notifikasi::create([
                        'user_id' => $user->id,
                        'tipe' => 'surat_keluar',
                        'judul' => 'Persetujuan Surat Keluar',
                        'pesan' => "Ada surat keluar baru yang memerlukan persetujuan Anda: #{$suratKeluar->no_surat}",
                        'is_read' => false,
                        'related_id' => $suratKeluar->id,
                        'related_type' => get_class($suratKeluar),
                    ]);
                }
            }

            // Auto-timestamp on status changes
            if ($newStatus == 'disetujui') {
                $suratKeluar->updateQuietly(['disetujui_at' => now()]);
            } elseif ($newStatus == 'ditolak') {
                $suratKeluar->updateQuietly(['ditolak_at' => now()]);
            }
        }
    }
}
