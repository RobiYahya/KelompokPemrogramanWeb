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
            $table->bigIncrements('id_histori');
            $table->unsignedBigInteger('id_user')->nullable(); // nullable: audit log tetap ada saat user dihapus
            $table->string('causer_name', 100)->nullable();    // snapshot nama user saat log ditulis; survive hard-delete
            $table->string('aksi', 50);
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->string('nama_barang', 50)->nullable();
            $table->text('deskripsi');
            $table->timestamp('tanggal')->nullable()->index(); // index: mempercepat query filter tanggal

            $table->foreign('id_user')
                ->references('id_user')->on('users')
                ->onDelete('set null'); // set null: histori tidak hilang saat user dihapus
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