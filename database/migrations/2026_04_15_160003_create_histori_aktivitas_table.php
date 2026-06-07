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
            $table->unsignedBigInteger('id_user');
            $table->string('aksi', 50);
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->string('nama_barang', 50)->nullable();
            $table->text('deskripsi');
            $table->timestamp('tanggal')->nullable(); // used as created_at (ActivityLog::CREATED_AT)

            $table->foreign('id_user')
                ->references('id_user')->on('users')
                ->onDelete('cascade');
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
