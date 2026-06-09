<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::paginate(10);
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/',
            ],
        ], [
            'nama_kategori.regex' => 'Kategori hanya boleh berisi huruf.',
        ]);

        $namaKategori = strtolower(trim($request->nama_kategori));
        $exists = Kategori::where('nama_kategori', $namaKategori)->exists();
        if ($exists) {
            return redirect()->back()
                ->withErrors(['nama_kategori' => 'This category already exists.'])
                ->with('error_pop', 'Category "' . $namaKategori . '" already exists in the system.')
                ->withInput();
        }

        $kategori = Kategori::create(['nama_kategori' => $namaKategori]);

        ActivityLog::log('create', 'Added category: ' . $kategori->nama_kategori, $kategori->id_kategori);

        return redirect()->route('kategori.index')->with('success', 'Category added successfully');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/',
            ],
        ], [
            'nama_kategori.regex' => 'Kategori hanya boleh berisi huruf.',
        ]);

        $namaKategori = strtolower(trim($request->nama_kategori));
        $exists = Kategori::where('nama_kategori', $namaKategori)
            ->where('id_kategori', '!=', $kategori->id_kategori)
            ->exists();
        if ($exists) {
            return redirect()->back()
                ->withErrors(['nama_kategori' => 'This category already exists.'])
                ->with('error_pop', 'Category "' . $namaKategori . '" already exists in the system.')
                ->withInput();
        }

        $kategori->update(['nama_kategori' => $namaKategori]);

        ActivityLog::log('update', 'Updated category: ' . $kategori->nama_kategori, $kategori->id_kategori);

        return redirect()->route('kategori.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Kategori $kategori)
    {
        $nama = $kategori->nama_kategori;
        $kategori->delete();

        ActivityLog::log('delete', 'Deleted category: ' . $nama);

        return redirect()->route('kategori.index')->with('success', 'Category deleted successfully');
    }
}