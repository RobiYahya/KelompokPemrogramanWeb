<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Services\StockTransactionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangMasukController extends Controller
{
    public function __construct(
        private StockTransactionService $service
    ) {}

    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);
        // BUG-009 Fix: Hanya ambil kolom yang dibutuhkan untuk dropdown modal
        $barang = Barang::select('id_barang', 'nama_barang', 'stok')->get();
        return view('barang_masuk.index', compact('barangMasuk', 'barang'));
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
            return redirect()->route('barang_masuk.index')->with('success', 'Incoming stock recorded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $validated = $request->validate([
            'id_barang' => [
                'required',
                Rule::exists('barang', 'id_barang')->where(function ($query) use ($barangMasuk, $request) {
                    // BUG-008 Fix: Gunakan strict comparison (int) === (int)
                    if ((int) $request->id_barang === (int) $barangMasuk->id_barang) {
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
            $this->service->update($validated, $barangMasuk);
            return redirect()->route('barang_masuk.index')->with('success', 'Incoming stock updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        try {
            $this->service->destroy($barangMasuk);
            return redirect()->route('barang_masuk.index')->with('success', 'Incoming stock record deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}