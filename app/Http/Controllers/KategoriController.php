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

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create([
            'nama' => $request->nama,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'Kategori',
            'model_id' => $kategori->id,
            'description' => 'Menambahkan kategori: ' . $kategori->nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'Kategori',
            'model_id' => $kategori->id,
            'description' => 'Mengubah kategori: ' . $kategori->nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Kategori $kategori)
    {
        $nama = $kategori->nama;
        $kategori->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'Kategori',
            'model_id' => $kategori->id,
            'description' => 'Menghapus kategori: ' . $nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}