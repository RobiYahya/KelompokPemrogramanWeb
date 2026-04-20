<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            SupplierSeeder::class,
            BarangSeeder::class,
            BarangMasukSeeder::class,
            BarangKeluarSeeder::class,
=======
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42
        ]);
    }
}
