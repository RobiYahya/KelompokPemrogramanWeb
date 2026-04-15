<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BarangMasuk;

class BarangMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = now()->toDateString();

        $barangMasuk = [
            ['barang_id' => 1, 'jumlah' => 5, 'tanggal' => $today, 'keterangan' => 'Stok tambahan'],
            ['barang_id' => 2, 'jumlah' => 20, 'tanggal' => $today, 'keterangan' => 'Restock kertas'],
            ['barang_id' => 4, 'jumlah' => 50, 'tanggal' => $today, 'keterangan' => 'Pengiriman baru'],
        ];

        foreach ($barangMasuk as $bm) {
            BarangMasuk::create($bm);
        }
    }
}
