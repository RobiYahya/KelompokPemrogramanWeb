<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class UpdateKategoriKeysSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::whereNull('key')->get()->each(function ($kategori) {
            $kategori->key = Kategori::generateRandomKey($kategori->nama);
            $kategori->save();
        });
    }
}
