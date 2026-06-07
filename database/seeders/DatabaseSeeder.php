<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('Admin@1234');

        // Super Admin
        User::firstOrCreate(
            ['id_pegawai' => 'SUP001'],
            [
                'nama'     => 'Super Admin',
                'email'    => 'superadmin@magura.com',
                'role'     => 'super_admin',
                'password' => $defaultPassword,
            ]
        );

        // Admin 1
        User::firstOrCreate(
            ['id_pegawai' => 'ADM001'],
            [
                'nama'     => 'Shofi',
                'email'    => 'shofi@magura.com',
                'role'     => 'admin',
                'password' => $defaultPassword,
            ]
        );

        // Admin 2
        User::firstOrCreate(
            ['id_pegawai' => 'ADM002'],
            [
                'nama'     => 'Cahya',
                'email'    => 'cahya@magura.com',
                'role'     => 'admin',
                'password' => $defaultPassword,
            ]
        );

        // Manager
        User::firstOrCreate(
            ['id_pegawai' => 'MGR001'],
            [
                'nama'     => 'Robi',
                'email'    => 'robi@magura.com',
                'role'     => 'manager',
                'password' => $defaultPassword,
            ]
        );
    }
}
