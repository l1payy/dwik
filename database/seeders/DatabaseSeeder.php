<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks to truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SuratMasuk::truncate();
        SuratKeluar::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Sekretaris
        $sekretaris = User::create([
            'name' => 'Sekretaris BPBD',
            'email' => 'sekretaris@bpbd.binjaikota.go.id',
            'password' => Hash::make('password'),
            'role' => 'sekretaris',
        ]);

        // Pimpinan
        $pimpinan = User::create([
            'name' => 'Kepala BPBD',
            'email' => 'pimpinan@bpbd.binjaikota.go.id',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
        ]);

        // Staff
        $staff = User::create([
            'name' => 'Staff BPBD',
            'email' => 'staff@bpbd.binjaikota.go.id',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Seed Surat Masuk
        SuratMasuk::create([
            'no_surat' => '001/MASUK/2026',
            'tanggal_surat' => '2026-05-01',
            'tanggal_masuk' => '2026-05-02',
            'pengirim' => 'Dinas Kesehatan Kota Binjai',
            'perihal' => 'Koordinasi Penanggulangan Bencana Non-Alam',
            'sifat' => 'penting',
            'prioritas' => 'urgent',
            'status' => 'selesai',
            'catatan' => 'Sudah didisposisikan ke Bidang Kedaruratan',
            'created_by' => $sekretaris->id,
            'instansi_pengirim' => 'Dinas Kesehatan Kota Binjai',
        ]);

        SuratMasuk::create([
            'no_surat' => '002/MASUK/2026',
            'tanggal_surat' => '2026-05-02',
            'tanggal_masuk' => '2026-05-03',
            'pengirim' => 'Sekretariat Daerah',
            'perihal' => 'Undangan Rapat Evaluasi Kinerja Triwulan',
            'sifat' => 'biasa',
            'prioritas' => 'normal',
            'status' => 'selesai',
            'catatan' => 'Kepala BPBD akan hadir',
            'created_by' => $sekretaris->id,
            'instansi_pengirim' => 'Sekretariat Daerah',
        ]);

        // Seed Surat Keluar
        SuratKeluar::create([
            'no_surat' => '001/KELUAR/2026',
            'tanggal_surat' => '2026-05-03',
            'penerima' => 'Walikota Binjai',
            'instansi_penerima' => 'Pemerintah Kota Binjai',
            'perihal' => 'Laporan Harian Pusdalops Penanggulangan Bencana',
            'sifat' => 'biasa',
            'status' => 'disetujui',
            'created_by' => $staff->id,
        ]);
    }
}
