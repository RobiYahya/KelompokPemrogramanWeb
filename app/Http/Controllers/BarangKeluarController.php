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
        $barangKeluar = BarangKeluar::with('barang')->latest()->paginate(10);
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

    public function edit(BarangKeluar $barangKeluar)
    {
        $barang = Barang::all();
        return view('barang_keluar.edit', compact('barangKeluar', 'barang'));
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        try {
            $validated = $request->validate([
                'barang_id' => 'required|exists:barang,id',
                'jumlah' => 'required|integer|min:1',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string|max:255',
            ]);

            // Kembalikan stok lama
            $barangLama = Barang::find($barangKeluar->barang_id);
            if ($barangLama) {
                $barangLama->stok += $barangKeluar->jumlah;
                $barangLama->save();
            }

            // Check if stok cukup untuk jumlah baru
            $barangBaru = Barang::find($request->barang_id);
            if ($barangBaru && $barangBaru->stok < $request->jumlah) {
                // Kembalikan stok lama karena gagal
                if ($barangLama) {
                    $barangLama->stok -= $barangKeluar->jumlah;
                    $barangLama->save();
                }
                return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok saat ini: ' . $barangBaru->stok);
            }

            // Update data
            $barangKeluar->update($validated);

            // Kurangi stok baru
            if ($barangBaru) {
                $barangBaru->stok -= $request->jumlah;
                $barangBaru->save();
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'model' => 'Barang Keluar',
                'model_id' => $barangKeluar->id,
                'description' => 'Mengupdate barang keluar: ' . ($barangBaru->nama ?? 'Unknown') . ' (' . $request->jumlah . ' unit)',
            ]);

            return redirect()->route('barang_keluar.index')->with('success', 'Barang keluar berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
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