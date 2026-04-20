<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
<<<<<<< HEAD
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\ActivityLogController;

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
        Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });

    // Supplier Routes
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::middleware(['admin'])->group(function () {
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    });

    // Barang Routes
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::middleware(['admin'])->group(function () {
        Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });

    // Barang Masuk Routes
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
    Route::middleware(['admin'])->group(function () {
        Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang_masuk.create');
        Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang_masuk.store');
        Route::delete('/barang-masuk/{barangMasuk}', [BarangMasukController::class, 'destroy'])->name('barang_masuk.destroy');
    });

    // Barang Keluar Routes
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang_keluar.index');
    Route::middleware(['admin'])->group(function () {
        Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barang_keluar.create');
        Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang_keluar.store');
        Route::delete('/barang-keluar/{barangKeluar}', [BarangKeluarController::class, 'destroy'])->name('barang_keluar.destroy');
    });

    // Activity Log Routes
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');
});
=======

// Route::get('/', function () {
    // return view('welcome');
// });

Route::get('/login', [LoginController::class, 'index']);
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42
