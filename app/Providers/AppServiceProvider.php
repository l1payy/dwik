<?php

namespace App\Providers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Notifikasi;
use App\Observers\SuratMasukObserver;
use App\Observers\SuratKeluarObserver;
use App\Observers\NotifikasiObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        SuratMasuk::observe(SuratMasukObserver::class);
        SuratKeluar::observe(SuratKeluarObserver::class);
        Notifikasi::observe(NotifikasiObserver::class);
    }
}
