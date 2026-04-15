<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['id_pegawai' => 'ADM001'],
            [
                'name' => 'Admin Gudang',
                'email' => 'admin@gudang.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['id_pegawai' => 'MNG001'],
            [
                'name' => 'Manajer Gudang',
                'email' => 'manajer@gudang.com',
                'role' => 'manager',
                'password' => Hash::make('password'),
            ]
        );
    }
}
