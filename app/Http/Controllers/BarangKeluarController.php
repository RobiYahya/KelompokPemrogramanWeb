<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('barang')->latest()->get();
        $barang = Barang::all();
        return view('barang_keluar.index', compact('barangKeluar', 'barang'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('barang_keluar.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $barang = Barang::find($request->barang_id);

        // Check if stok cukup
        if ($barang->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok saat ini: ' . $barang->stok);
        }

        $barangKeluar = BarangKeluar::create($request->all());

        // Update stok barang
        $barang->stok -= $request->jumlah;
        $barang->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'barang_keluar',
            'model' => 'Barang Keluar',
            'model_id' => $barangKeluar->id,
            'description' => $request->keterangan ?? 'Menambahkan barang keluar: ' . $barang->nama . ' (' . $request->jumlah . ' unit)',
        ]);

        return redirect()->route('barang_keluar.index')->with('success', 'Barang keluar berhasil dicatat');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        // Tambah stok barang kembali
        $barang = Barang::find($barangKeluar->barang_id);
        $barang->stok += $barangKeluar->jumlah;
        $barang->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'Barang Keluar',
            'model_id' => $barangKeluar->id,
            'description' => 'Menghapus barang keluar: ' . $barang->nama,
        ]);

        $barangKeluar->delete();
        return redirect()->route('barang_keluar.index')->with('success', 'Data barang keluar berhasil dihapus');
    }
}
