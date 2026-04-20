<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Kategori;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
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
}
