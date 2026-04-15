<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BarangKeluar;

class BarangKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = now()->toDateString();

        $barangKeluar = [
            ['barang_id' => 2, 'jumlah' => 10, 'tanggal' => $today, 'keterangan' => 'Penggunaan kantor'],
            ['barang_id' => 4, 'jumlah' => 25, 'tanggal' => $today, 'keterangan' => 'Distribusi'],
        ];

        foreach ($barangKeluar as $bk) {
            BarangKeluar::create($bk);
        }
    }
}
