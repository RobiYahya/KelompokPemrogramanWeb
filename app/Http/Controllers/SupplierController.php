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

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:50',
            'kontak'        => 'nullable|string|max:50',
            'no_telp'       => 'nullable|string|max:20',
            'alamat'        => 'nullable|string|max:50',
        ]);

        $supplier = Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'kontak'        => $request->kontak,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
        ]);

        ActivityLog::log('create', 'Added supplier: ' . $supplier->nama_supplier);

        return redirect()->route('supplier.index')->with('success', 'Supplier added successfully');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:50',
            'kontak'        => 'nullable|string|max:50',
            'no_telp'       => 'nullable|string|max:20',
            'alamat'        => 'nullable|string|max:50',
        ]);

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'kontak'        => $request->kontak,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
        ]);

        ActivityLog::log('update', 'Updated supplier: ' . $supplier->nama_supplier);

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully');
    }

    public function destroy(Supplier $supplier)
    {
        $nama = $supplier->nama_supplier;
        $supplier->delete();

        ActivityLog::log('delete', 'Deleted supplier: ' . $nama);

        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully');
    }
}