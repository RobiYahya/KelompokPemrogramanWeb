<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['nama' => 'Elektronik'],
            ['nama' => 'Peralatan Kantor'],
            ['nama' => 'Bahan Baku'],
            ['nama' => 'Makanan'],
            ['nama' => 'Minuman'],
        ];

        foreach ($kategori as $k) {
            Kategori::create([
                'nama' => $k['nama'],
            ]);
        }
    }
}
