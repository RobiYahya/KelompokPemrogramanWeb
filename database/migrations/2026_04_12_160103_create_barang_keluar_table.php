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
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->bigIncrements('id_keluar');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_user')->nullable(); // nullable: transaksi tetap ada saat user dihapus
            $table->unsignedInteger('jumlah');                 // unsigned: jumlah tidak bisa negatif
            $table->date('tanggal')->index();                  // index: mempercepat query filter tanggal
            $table->string('deskripsi', 50)->nullable();
            $table->timestamps();

            $table->foreign('id_barang')
                ->references('id_barang')->on('barang')
                ->onDelete('cascade');

            $table->foreign('id_user')
                ->references('id_user')->on('users')
                ->onDelete('set null'); // set null: data transaksi tidak hilang saat user dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};