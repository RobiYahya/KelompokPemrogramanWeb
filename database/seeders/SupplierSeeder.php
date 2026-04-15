<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplier = [
            ['nama' => 'PT. Elektronik Jaya', 'kontak' => 'Budi', 'telepon' => '081234567890', 'alamat' => 'Jakarta'],
            ['nama' => 'CV. Kantor Mandiri', 'kontak' => 'Siti', 'telepon' => '081234567891', 'alamat' => 'Surabaya'],
            ['nama' => 'UD. Bahan Baku', 'kontak' => 'Ahmad', 'telepon' => '081234567892', 'alamat' => 'Bandung'],
        ];

        foreach ($supplier as $s) {
            Supplier::create($s);
        }
    }
}
