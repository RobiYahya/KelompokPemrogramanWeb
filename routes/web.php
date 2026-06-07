<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori Routes
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::middleware(['admin'])->group(function () {
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });

    // Supplier Routes
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::middleware(['admin'])->group(function () {
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    });

    // Barang Routes
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::middleware(['admin'])->group(function () {
        Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
        Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });

    // Barang Masuk Routes
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
    Route::middleware(['admin'])->group(function () {
        Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang_masuk.store');
        Route::put('/barang-masuk/{barangMasuk}', [BarangMasukController::class, 'update'])->name('barang_masuk.update');
        Route::delete('/barang-masuk/{barangMasuk}', [BarangMasukController::class, 'destroy'])->name('barang_masuk.destroy');
    });

    // Barang Keluar Routes
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang_keluar.index');
    Route::middleware(['admin'])->group(function () {
        Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang_keluar.store');
        Route::put('/barang-keluar/{barangKeluar}', [BarangKeluarController::class, 'update'])->name('barang_keluar.update');
        Route::delete('/barang-keluar/{barangKeluar}', [BarangKeluarController::class, 'destroy'])->name('barang_keluar.destroy');
    });

    // Activity Log Routes
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');

    // User Management Routes (Super Admin only)
    Route::middleware(['super_admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Report Routes — accessible by admin and manager roles
    Route::middleware(['admin_or_manager'])->group(function () {
        Route::get('/reports/preview', [ReportController::class, 'preview'])->name('reports.preview');
        Route::post('/reports/download', [ReportController::class, 'download'])->name('reports.download');
    });
});