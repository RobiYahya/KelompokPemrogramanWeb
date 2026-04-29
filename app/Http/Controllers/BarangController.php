<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with(['kategori', 'supplier'])->paginate(10);
        $kategori = Kategori::all();
        $supplier = Supplier::all();
        return view('barang.index', compact('barang', 'kategori', 'supplier'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $supplier = Supplier::all();
        return view('barang.create', compact('kategori', 'supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'supplier_id' => 'required|exists:supplier,id',
            'stok' => 'required|integer|min:0',
            'minimum_stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $barang = Barang::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'Barang',
            'model_id' => $barang->id,
            'description' => 'Menambahkan barang: ' . $barang->nama,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $supplier = Supplier::all();
        return view('barang.edit', compact('barang', 'kategori', 'supplier'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'supplier_id' => 'required|exists:supplier,id',
            'stok' => 'required|integer|min:0',
            'minimum_stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $barang->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'Barang',
            'model_id' => $barang->id,
            'description' => 'Mengubah barang: ' . $barang->nama,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Barang $barang)
    {
        $nama = $barang->nama;
        $barang->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'Barang',
            'model_id' => $barang->id,
            'description' => 'Menghapus barang: ' . $nama,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}