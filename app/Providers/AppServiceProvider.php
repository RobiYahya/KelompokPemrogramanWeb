<?php

namespace App\Providers;

use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Services\StockTransactionService;
use App\Services\TransaksiMasuk;
use App\Services\TransaksiKeluar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Saat BarangMasukController di-resolve → injeksikan TransaksiMasuk
        $this->app->when(BarangMasukController::class)
            ->needs(StockTransactionService::class)
            ->give(fn() => new StockTransactionService(new TransaksiMasuk()));

        // Saat BarangKeluarController di-resolve → injeksikan TransaksiKeluar
        $this->app->when(BarangKeluarController::class)
            ->needs(StockTransactionService::class)
            ->give(fn() => new StockTransactionService(new TransaksiKeluar()));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
