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
        Schema::create('histori_aktivitas', function (Blueprint $table) {
            $table->id('id_histori');
            $table->foreignId('id_user')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->string('aksi', 100);
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->string('nama_barang', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamp('tanggal')->useCurrent();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_aktivitas');
    }
};
