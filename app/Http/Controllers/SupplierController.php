<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::paginate(10);
        return view('supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
        ]);

        $supplier = Supplier::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'Supplier',
            'model_id' => $supplier->id,
            'description' => 'Menambahkan supplier: ' . $supplier->nama,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
        ]);

        $supplier->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'Supplier',
            'model_id' => $supplier->id,
            'description' => 'Mengubah supplier: ' . $supplier->nama,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui');
    }

    public function destroy(Supplier $supplier)
    {
        $nama = $supplier->nama;
        $supplier->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'Supplier',
            'model_id' => $supplier->id,
            'description' => 'Menghapus supplier: ' . $nama,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus');
    }
}