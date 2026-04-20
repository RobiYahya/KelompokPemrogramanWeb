<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Kategori;
use App\Models\Supplier;
=======
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42

class DashboardController extends Controller
{
    public function index()
<<<<<<< HEAD
    {
        $today = now()->toDateString();

        // Data barang masuk hari ini
        $barangMasukHariIni = BarangMasuk::whereDate('tanggal', $today)->sum('jumlah');

        // Data barang keluar hari ini
        $barangKeluarHariIni = BarangKeluar::whereDate('tanggal', $today)->sum('jumlah');

        // Total stok semua barang
        $totalStok = Barang::sum('stok');

        // Total kategori
        $totalKategori = Kategori::count();

        // Total supplier
        $totalSupplier = Supplier::count();

        // Data barang dengan stok minimum
        $barangLowStock = Barang::with(['kategori', 'supplier'])->whereColumn('stok', '<=', 'minimum_stok')->get();

        return view('dashboard', compact(
            'barangMasukHariIni',
            'barangKeluarHariIni',
            'totalStok',
            'totalKategori',
            'totalSupplier',
            'barangLowStock'
        ));
    }
=======
{
    return view('dashboard');
}
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42
}
