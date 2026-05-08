<?php

namespace App\Providers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Models\Notifikasi;
use App\Observers\SuratMasukObserver;
use App\Observers\SuratKeluarObserver;
use App\Observers\DisposisiObserver;
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
        Disposisi::observe(DisposisiObserver::class);
        Notifikasi::observe(NotifikasiObserver::class);
    }
}
