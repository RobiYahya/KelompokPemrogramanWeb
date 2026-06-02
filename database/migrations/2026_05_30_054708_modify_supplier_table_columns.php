<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->string('nama_supplier', 255)->change();
            $table->string('kontak', 255)->nullable()->change();
            $table->string('no_telp', 50)->nullable()->change();
            $table->text('alamat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->string('nama_supplier', 50)->change();
            $table->string('kontak', 50)->nullable()->change();
            $table->string('no_telp', 50)->nullable()->change();
            $table->string('alamat', 50)->nullable()->change();
        });
    }
};