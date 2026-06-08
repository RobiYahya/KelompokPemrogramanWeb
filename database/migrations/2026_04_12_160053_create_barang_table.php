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
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('id_barang');
            $table->string('nama_barang', 50);
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->unsignedBigInteger('id_supplier')->nullable();
            $table->unsignedInteger('stok')->default(0);     // unsigned: stok tidak bisa negatif
            $table->unsignedInteger('min_stok')->default(10); // unsigned: min stok tidak bisa negatif
            $table->decimal('harga', 10, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_kategori')
                ->references('id_kategori')->on('kategori')
                ->onDelete('set null');

            $table->foreign('id_supplier')
                ->references('id_supplier')->on('supplier')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};