<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class CheckDataSeeder extends Seeder
{
    public function run(): void
    {
        echo "=== DATA KATEGORI ===\n";
        $kategori = Kategori::all();
        foreach ($kategori as $k) {
            echo "ID: {$k->id}, Formatted ID: {$k->formatted_id}, Nama: {$k->nama}\n";
        }
    }
}
