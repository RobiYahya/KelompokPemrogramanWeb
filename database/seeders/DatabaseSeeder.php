<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Import database.sql to wipe and recreate tables + seed user data
        $sql = file_get_contents(base_path('database.sql'));
        DB::unprepared($sql);
    }
}
