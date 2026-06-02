<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface StockTransactionInterface
{
    public function prosesStok(\App\Models\Barang $barang, int $jumlah): void;

    public function kembalikanStok(\App\Models\Barang $barang, int $jumlah): void;

    public function buatRecord(int $idBarang, int $jumlah, string $tanggal, ?string $deskripsi): void;

    public function getLogPrefix(): string;

    public function getLabel(): string;
}