<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Surat Masuk
    Route::get('surat-masuk', [SuratMasukController::class, 'index'])->name('surat-masuk.index');
    Route::get('surat-masuk/create', [SuratMasukController::class, 'create'])->name('surat-masuk.create')->middleware('role:sekretaris');
    Route::post('surat-masuk', [SuratMasukController::class, 'store'])->name('surat-masuk.store')->middleware('role:sekretaris');
    Route::get('surat-masuk/{surat_masuk}', [SuratMasukController::class, 'show'])->name('surat-masuk.show');
    Route::get('surat-masuk/{surat_masuk}/edit', [SuratMasukController::class, 'edit'])->name('surat-masuk.edit')->middleware('role:sekretaris');
    Route::put('surat-masuk/{surat_masuk}', [SuratMasukController::class, 'update'])->name('surat-masuk.update')->middleware('role:sekretaris');
    Route::delete('surat-masuk/{surat_masuk}', [SuratMasukController::class, 'destroy'])->name('surat-masuk.destroy')->middleware('role:sekretaris');

    // Surat Keluar
    Route::get('surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.index');
    Route::get('surat-keluar/create', [SuratKeluarController::class, 'create'])->name('surat-keluar.create')->middleware('role:sekretaris');
    Route::post('surat-keluar', [SuratKeluarController::class, 'store'])->name('surat-keluar.store')->middleware('role:sekretaris');
    Route::get('surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'show'])->name('surat-keluar.show');
    Route::get('surat-keluar/{surat_keluar}/edit', [SuratKeluarController::class, 'edit'])->name('surat-keluar.edit')->middleware('role:sekretaris');
    Route::put('surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'update'])->name('surat-keluar.update')->middleware('role:sekretaris');
    Route::delete('surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'destroy'])->name('surat-keluar.destroy')->middleware('role:sekretaris');
    Route::get('surat-keluar/{surat_keluar}/export/pdf', [SuratKeluarController::class, 'exportPdf'])->name('surat-keluar.export.pdf')->middleware('role:pimpinan,sekretaris');
    Route::get('surat-keluar/{surat_keluar}/export/word', [SuratKeluarController::class, 'exportWord'])->name('surat-keluar.export.word')->middleware('role:pimpinan,sekretaris');

    // Notifikasi
    Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('notifikasi/{notifikasi}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index')->middleware('role:pimpinan,sekretaris');
    Route::get('laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf')->middleware('role:pimpinan,sekretaris');
    Route::get('laporan/export/word', [LaporanController::class, 'exportWord'])->name('laporan.export.word')->middleware('role:pimpinan,sekretaris');
    
});

require __DIR__.'/auth.php';
