<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Users
        $pimpinan = User::updateOrCreate(
            ['email' => 'pimpinan@bpbd.binjaikota.go.id'],
            [
                'name' => 'Kepala BPBD Binjai',
                'password' => Hash::make('password'),
                'role' => 'pimpinan',
            ]
        );

        $sekretaris = User::updateOrCreate(
            ['email' => 'sekretaris@bpbd.binjaikota.go.id'],
            [
                'name' => 'Sekretaris BPBD Binjai',
                'password' => Hash::make('password'),
                'role' => 'sekretaris',
            ]
        );

        $staff = User::updateOrCreate(
            ['email' => 'staff@bpbd.binjaikota.go.id'],
            [
                'name' => 'Staff Administrasi',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        // Surat Masuk
        for ($i = 1; $i <= 5; $i++) {
            SuratMasuk::create([
                'no_surat' => "00$i/BPBD/MSK/" . now()->year,
                'no_agenda' => "AGD-00$i",
                'tanggal_surat' => now()->subDays($i * 2),
                'tanggal_masuk' => now()->subDays($i),
                'pengirim' => "Nama Pengirim $i",
                'instansi_pengirim' => "Instansi Contoh $i",
                'perihal' => "Perihal Surat Masuk Ke-$i",
                'sifat' => $i % 3 == 0 ? 'rahasia' : ($i % 2 == 0 ? 'penting' : 'biasa'),
                'prioritas' => $i % 2 == 0 ? 'urgent' : 'normal',
                'status' => $i == 1 ? 'selesai' : ($i == 2 ? 'terdisposisi' : 'diterima'),
                'file_lampiran' => null,
                'created_by' => $sekretaris->id,
            ]);
        }

        // Surat Keluar
        for ($i = 1; $i <= 5; $i++) {
            SuratKeluar::create([
                'no_surat' => "00$i/BPBD/KLR/" . now()->year,
                'tanggal_surat' => now()->subDays($i),
                'penerima' => "Nama Penerima $i",
                'instansi_penerima' => "Tujuan Contoh $i",
                'perihal' => "Perihal Surat Keluar Ke-$i",
                'sifat' => $i % 3 == 0 ? 'Rahasia' : 'Biasa',
                'status' => $i == 1 ? 'disetujui' : ($i == 2 ? 'menunggu_persetujuan' : 'draft'),
                'file_lampiran' => null,
                'created_by' => $sekretaris->id,
            ]);
        }

        // Disposisi
        $suratDisposisi = SuratMasuk::where('status', 'terdisposisi')->first();
        if ($suratDisposisi) {
            Disposisi::create([
                'surat_masuk_id' => $suratDisposisi->id,
                'dari_user_id' => $pimpinan->id,
                'kepada_user_id' => $sekretaris->id,
                'no_disposisi' => 'DISP-' . now()->format('YmdHis'),
                'instruksi' => 'Mohon segera ditindaklanjuti dan dikoordinasikan.',
                'prioritas' => 'Segera',
                'status' => 'diproses',
                'batas_waktu' => now()->addDays(3),
            ]);
        }
    }
}
