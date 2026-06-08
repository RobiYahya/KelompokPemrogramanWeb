<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\BarangKeluar;

class TransaksiKeluar extends BaseStockTransaction
{
    public function prosesStok(Barang $barang, int $jumlah): void
    {
        if ($barang->stok < $jumlah) {
            throw new \Exception('Insufficient stock! Current stock: ' . $barang->stok . ' units');
        }

        $barang->decrement('stok', $jumlah);
    }

    public function kembalikanStok(Barang $barang, int $jumlah): void
    {
        $barang->increment('stok', $jumlah);
    }

    public function buatRecord(int $idBarang, int $jumlah, string $tanggal, ?string $deskripsi): void
    {
        BarangKeluar::create([
            'id_barang' => $idBarang,
            'id_user'   => auth()->id(),
            'jumlah'    => $jumlah,
            'tanggal'   => $tanggal,
            'deskripsi' => $deskripsi,
        ]);
    }

    public function getLogPrefix(): string
    {
        return 'Outgoing';
    }

    public function getLabel(): string
    {
        return 'barang_keluar';
    }

    protected function validasiSebelumUpdate(Barang $barang, int $jumlah): void
    {
        $stokTersedia = $barang->stok;

        if ($stokTersedia < $jumlah) {
            throw new \Exception('Insufficient stock! Available stock: ' . $stokTersedia . ' units');
        }
    }
}