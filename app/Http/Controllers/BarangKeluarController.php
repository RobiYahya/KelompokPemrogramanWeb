<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Services\StockTransactionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangKeluarController extends Controller
{

    public function __construct(
        private StockTransactionService $service
    ) {}

    public function index()
    {
        $barangKeluar = BarangKeluar::with('barang')->latest()->paginate(10);
        // BUG-009 Fix: Hanya ambil kolom yang dibutuhkan untuk dropdown modal
        $barang = Barang::select('id_barang', 'nama_barang', 'stok')->get();
        return view('barang_keluar.index', compact('barangKeluar', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => [
                'required',
                Rule::exists('barang', 'id_barang')->whereNull('deleted_at'),
            ],
            'jumlah'    => 'required|integer|min:1',
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string|max:50',
        ]);

        try {
            $this->service->store($request);
            return redirect()->route('barang_keluar.index')->with('success', 'Outgoing stock recorded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $validated = $request->validate([
            'id_barang' => [
                'required',
                Rule::exists('barang', 'id_barang')->where(function ($query) use ($barangKeluar, $request) {
                    // BUG-008 Fix: Gunakan strict comparison (int) === (int)
                    if ((int) $request->id_barang === (int) $barangKeluar->id_barang) {
                        return $query;
                    }
                    return $query->whereNull('deleted_at');
                }),
            ],
            'jumlah'    => 'required|integer|min:1',
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string|max:50',
        ]);

        try {
            $this->service->update($validated, $barangKeluar);
            return redirect()->route('barang_keluar.index')->with('success', 'Outgoing stock updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        try {
            $this->service->destroy($barangKeluar);
            return redirect()->route('barang_keluar.index')->with('success', 'Outgoing stock record deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}