<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\BarangMasuk;

class TransaksiMasuk extends BaseStockTransaction
{
    /**
     * Barang masuk → tambah stok.
     */
    public function prosesStok(Barang $barang, int $jumlah): void
    {
        $barang->increment('stok', $jumlah);
    }

    /**
     * Batalkan barang masuk → kurangi stok kembali.
     */
    public function kembalikanStok(Barang $barang, int $jumlah): void
    {
        $barang->decrement('stok', $jumlah);
    }

    /**
     * Buat record di tabel barang_masuk.
     */
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

    /**
     * Prefix human-readable untuk teks deskripsi ActivityLog.
     */
    public function getLogPrefix(): string
    {
        return 'Incoming';
    }

    /**
     * Nilai aksi yang disimpan ke DB — harus cocok dengan
     * pengecekan di ActivityLogController & ReportController.
     */
    public function getLabel(): string
    {
        return 'barang_masuk';
    }
}