<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\BarangMasuk;

class TransaksiMasuk extends BaseStockTransaction
{

    public function prosesStok(Barang $barang, int $jumlah): void
    {
        $barang->increment('stok', $jumlah);
    }

    public function kembalikanStok(Barang $barang, int $jumlah): void
    {
        $barang->decrement('stok', $jumlah);
    }

    public function buatRecord(int $idBarang, int $jumlah, string $tanggal, ?string $deskripsi): void
    {
        BarangMasuk::create([
            'id_barang' => $idBarang,
            'id_user'   => auth()->id(),
            'jumlah'    => $jumlah,
            'tanggal'   => $tanggal,
            'deskripsi' => $deskripsi,
        ]);
    }

    public function getLogPrefix(): string
    {
        return 'Incoming';
    }

    public function getLabel(): string
    {
        return 'barang_masuk';
    }
}