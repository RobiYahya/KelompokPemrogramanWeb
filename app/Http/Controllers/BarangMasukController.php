<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);
        $barang = Barang::all();
        return view('barang_masuk.index', compact('barangMasuk', 'barang'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('barang_masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $barangMasuk = BarangMasuk::create($request->all());

        // Update stok barang
        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->jumlah;
        $barang->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'barang_masuk',
            'model' => 'Barang Masuk',
            'model_id' => $barangMasuk->id,
            'description' => $request->keterangan ?? 'Menambahkan barang masuk: ' . $barang->nama . ' (' . $request->jumlah . ' unit)',
        ]);

        return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil dicatat');
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $barang = Barang::all();
        return view('barang_masuk.edit', compact('barangMasuk', 'barang'));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        try {
            $validated = $request->validate([
                'barang_id' => 'required|exists:barang,id',
                'jumlah' => 'required|integer|min:1',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string|max:255',
            ]);

            // Kembalikan stok lama
            $barangLama = Barang::find($barangMasuk->barang_id);
            if ($barangLama) {
                $barangLama->stok -= $barangMasuk->jumlah;
                $barangLama->save();
            }

            // Update data
            $barangMasuk->update($validated);

            // Tambah stok baru
            $barangBaru = Barang::find($request->barang_id);
            if ($barangBaru) {
                $barangBaru->stok += $request->jumlah;
                $barangBaru->save();
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'model' => 'Barang Masuk',
                'model_id' => $barangMasuk->id,
                'description' => 'Mengupdate barang masuk: ' . ($barangBaru->nama ?? 'Unknown') . ' (' . $request->jumlah . ' unit)',
            ]);

            return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        // Kurangi stok barang
        $barang = Barang::find($barangMasuk->barang_id);
        $barang->stok -= $barangMasuk->jumlah;
        $barang->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'Barang Masuk',
            'model_id' => $barangMasuk->id,
            'description' => 'Menghapus barang masuk: ' . $barang->nama,
        ]);

        $barangMasuk->delete();
        return redirect()->route('barang_masuk.index')->with('success', 'Data barang masuk berhasil dihapus');
    }
}