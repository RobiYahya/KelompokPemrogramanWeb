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

    /**
     * Batalkan barang keluar → kembalikan stok.
     */
    public function kembalikanStok(Barang $barang, int $jumlah): void
    {
        $barang->increment('stok', $jumlah);
    }

    /**
     * Buat record di tabel barang_keluar.
     */
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

    /**
     * Prefix human-readable untuk teks deskripsi ActivityLog.
     */
    public function getLogPrefix(): string
    {
        return 'Outgoing';
    }

    /**
     * Nilai aksi yang disimpan ke DB — harus cocok dengan
     * pengecekan di ActivityLogController & ReportController.
     */
    public function getLabel(): string
    {
        return 'barang_keluar';
    }

    /**
     * Override hook validasi: cek stok tersedia sebelum update.
     * Hanya TransaksiKeluar yang butuh validasi ini.
     */
    protected function validasiSebelumUpdate(Barang $barang, int $jumlah): void
    {
        $stokTersedia = $barang->fresh()->stok;

        if ($stokTersedia < $jumlah) {
            throw new \Exception('Insufficient stock! Available stock: ' . $stokTersedia . ' units');
        }
    }
}