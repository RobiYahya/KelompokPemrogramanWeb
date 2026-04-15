<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = [
            ['nama' => 'Laptop ASUS', 'kategori_id' => 1, 'supplier_id' => 1, 'stok' => 3, 'minimum_stok' => 5, 'harga_beli' => 8000000, 'harga_jual' => 9500000],
            ['nama' => 'Kertas A4', 'kategori_id' => 2, 'supplier_id' => 2, 'stok' => 100, 'minimum_stok' => 20, 'harga_beli' => 45000, 'harga_jual' => 55000],
            ['nama' => 'Besi Beton', 'kategori_id' => 3, 'supplier_id' => 3, 'stok' => 50, 'minimum_stok' => 15, 'harga_beli' => 75000, 'harga_jual' => 90000],
            ['nama' => 'Air Mineral', 'kategori_id' => 5, 'supplier_id' => 1, 'stok' => 40, 'minimum_stok' => 50, 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['nama' => 'Mouse Logitech', 'kategori_id' => 1, 'supplier_id' => 1, 'stok' => 30, 'minimum_stok' => 10, 'harga_beli' => 120000, 'harga_jual' => 150000],
        ];

        foreach ($barang as $b) {
            Barang::create($b);
        }
    }
}
