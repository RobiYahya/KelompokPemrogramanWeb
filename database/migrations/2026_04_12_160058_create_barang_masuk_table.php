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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->bigIncrements('id_masuk');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_user');
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->string('deskripsi', 50)->nullable();
            $table->timestamps();

            $table->foreign('id_barang')
                ->references('id_barang')->on('barang')
                ->onDelete('cascade');

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
        Schema::dropIfExists('barang_masuk');
    }
};
