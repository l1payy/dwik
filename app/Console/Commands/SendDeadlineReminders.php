<?php

namespace App\Console\Commands;

use App\Models\SuratMasuk;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-deadline-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi pengingat deadline H-1 untuk Surat Masuk';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        $suratBesok = SuratMasuk::whereDate('deadline', $tomorrow)
            ->where('status', '!=', 'selesai')
            ->get();

        if ($suratBesok->isEmpty()) {
            $this->info('Tidak ada surat dengan deadline besok.');
            return;
        }

        foreach ($suratBesok as $surat) {
            // Notify Creator
            $this->createNotification($surat->created_by, $surat);

            // Notify Pimpinan & Sekretaris
            $users = User::whereIn('role', ['pimpinan', 'sekretaris'])->get();
            foreach ($users as $user) {
                if ($user->id != $surat->created_by) {
                    $this->createNotification($user->id, $surat);
                }
            }
        }

        $this->info('Notifikasi pengingat deadline berhasil dikirim untuk ' . $suratBesok->count() . ' surat.');
    }

    private function createNotification($userId, $surat)
    {
        Notifikasi::create([
            'user_id' => $userId,
            'tipe' => 'deadline_reminder',
            'judul' => 'Pengingat Deadline H-1',
            'pesan' => "Surat Masuk #{$surat->no_surat} ({$surat->perihal}) akan mencapai batas waktu besok.",
            'is_read' => false,
        ]);
    }
}
