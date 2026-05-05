<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Create Users
        User::create([
            'name' => 'Shofi',
            'email' => 'shofi@Magura.com',
            'id_pegawai' => 'ADM001',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Cahya',
            'email' => 'cahya@Magura.com',
            'id_pegawai' => 'ADM002',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Robi',
            'email' => 'robi@Magura.com',
            'id_pegawai' => 'MGR001',
            'role' => 'manager',
            'password' => Hash::make('password'),
        ]);

        // 2. Create Kategori
        $kategoriList = [
            ['nama' => 'Minuman'],
            ['nama' => 'Makanan'],
        ];
        foreach ($kategoriList as $k) {
            Kategori::create($k);
        }

        // 3. Create Supplier
        $supplierList = [
            ['nama' => 'PT Aqua Danone', 'kontak' => 'Bapak Andi', 'telepon' => '081234567890', 'alamat' => 'Jl. Sudirman No. 45, Jakarta'],
            ['nama' => 'CV Green Tea Indo', 'kontak' => 'Ibu Sari', 'telepon' => '082345678901', 'alamat' => 'Jl. Imam Bonjol No. 12, Bandung'],
        ];
        foreach ($supplierList as $s) {
            Supplier::create($s);
        }

        // 4. Create Barang
        $barangList = [
            ['nama' => 'Aqua 600ml', 'kategori_id' => 1, 'supplier_id' => 1, 'stok' => 100, 'minimum_stok' => 20, 'harga_beli' => 3000],
            ['nama' => 'Green Tea Botol', 'kategori_id' => 1, 'supplier_id' => 2, 'stok' => 50, 'minimum_stok' => 10, 'harga_beli' => 5000],
        ];
        foreach ($barangList as $b) {
            Barang::create($b);
        }

    }
}
