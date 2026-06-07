<?php

use Illuminate\Database\Migrations\Migration;

// This migration is intentionally a no-op.
// The barang_masuk and barang_keluar tables were fully rewritten in
// 2026_04_12_160058 and 2026_04_12_160103 with correct column types.
// No further schema change is needed here.

return new class extends Migration
{
    public function up(): void
    {
        // No-op: schema already correct in base migrations.
    }

    public function down(): void
    {
        // No-op.
    }
};
