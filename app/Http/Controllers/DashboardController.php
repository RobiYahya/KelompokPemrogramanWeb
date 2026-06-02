<?php

namespace App\Http\Controllers;


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

        // Barang dengan stok di bawah atau sama dengan minimum stok
        // Kolom yang benar adalah 'min_stok' (bukan 'minimum_stok')
        $barangLowStock = Barang::with(['kategori', 'supplier'])
            ->whereColumn('stok', '<=', 'min_stok')
            ->get();

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
