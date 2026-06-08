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
        $barang   = Barang::with(['kategori', 'supplier'])->paginate(10);
        // BUG-009 Fix: Hanya ambil kolom yang dibutuhkan untuk dropdown modal
        $kategori = Kategori::select('id_kategori', 'nama_kategori')->get();
        $supplier = Supplier::select('id_supplier', 'nama_supplier')->get();
        return view('barang.index', compact('barang', 'kategori', 'supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:50',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'stok'        => 'required|integer|min:0',
            'min_stok'    => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
        ]);

        $barang = Barang::create($request->only([
            'nama_barang', 'id_kategori', 'id_supplier', 'stok', 'min_stok', 'harga'
        ]));

        ActivityLog::log('create', 'Added item: ' . $barang->nama_barang, $barang->id_kategori, $barang->nama_barang);

        return redirect()->route('barang.index')->with('success', 'Item added successfully');
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:50',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'stok'        => 'required|integer|min:0',
            'min_stok'    => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
        ]);

        $barang->update($request->only([
            'nama_barang', 'id_kategori', 'id_supplier', 'stok', 'min_stok', 'harga'
        ]));

        ActivityLog::log('update', 'Updated item: ' . $barang->nama_barang, $barang->id_kategori, $barang->nama_barang);

        return redirect()->route('barang.index')->with('success', 'Item updated successfully');
    }

    public function destroy(Barang $barang)
    {
        $idKategori = $barang->id_kategori;
        $namaBarang = $barang->nama_barang;
        $barang->delete();

        ActivityLog::log('delete', 'Deleted item: ' . $namaBarang, $idKategori, $namaBarang);

        return redirect()->route('barang.index')->with('success', 'Item deleted successfully');
    }
}
