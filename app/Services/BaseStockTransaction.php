<?php

namespace App\Services;

use App\Contracts\StockTransactionInterface;
use App\Models\Barang;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class BaseStockTransaction implements StockTransactionInterface
{

    public function store(Request $request): void
    {
        DB::transaction(function () use ($request) {
            $barang = Barang::where('id_barang', $request->id_barang)
                ->lockForUpdate()
                ->first();

            if (!$barang) {
                throw new \Exception('Item not found. It may have been deleted.');
            }

            $this->buatRecord(
                $request->id_barang,
                $request->jumlah,
                $request->tanggal,
                $request->deskripsi
            );

            $this->prosesStok($barang, $request->jumlah);

            ActivityLog::log(
                $this->getLabel(),
                $this->getLogPrefix() . ' item: ' . $barang->nama_barang . ' (' . $request->jumlah . ' units)',
                $barang->id_kategori,
                $barang->nama_barang
            );
        });
    }
    public function update(array $validated, $transaction): void
    {
        DB::transaction(function () use ($validated, $transaction) {
            $barangLama = Barang::withTrashed()
                ->where('id_barang', $transaction->id_barang)
                ->lockForUpdate()
                ->first();

            // Kembalikan efek stok lama (polymorphisme)
            if ($barangLama) {
                $this->kembalikanStok($barangLama, $transaction->jumlah);
            }

            $barangBaru = Barang::withTrashed()
                ->where('id_barang', $validated['id_barang'])
                ->lockForUpdate()
                ->first();

            $this->validasiSebelumUpdate($barangBaru, $validated['jumlah']);

            $transaction->update([
                'id_barang' => $validated['id_barang'],
                'jumlah'    => $validated['jumlah'],
                'tanggal'   => $validated['tanggal'],
                'deskripsi' => $validated['deskripsi'],
            ]);

            // Terapkan efek stok baru (polymorphisme)
            if ($barangBaru) {
                $this->prosesStok($barangBaru, $validated['jumlah']);
            }

            ActivityLog::log(
                'update',
                'Updated ' . strtolower($this->getLogPrefix()) . ' item: '
                    . ($barangBaru->nama_barang ?? 'Unknown')
                    . ' (' . $validated['jumlah'] . ' units)',
                $barangBaru->id_kategori ?? null,
                $barangBaru->nama_barang ?? 'Unknown'
            );
        });
    }

    public function destroy($transaction): void
    {
        DB::transaction(function () use ($transaction) {
            $idBarang = $transaction->id_barang;
            $jumlah   = $transaction->jumlah;

            $transaction->delete();

            $barang = Barang::withTrashed()
                ->where('id_barang', $idBarang)
                ->lockForUpdate()
                ->first();

            if ($barang) {
                // polymorphisme: kembalikanStok() berbeda untuk masuk/keluar
                $this->kembalikanStok($barang, $jumlah);

                ActivityLog::log(
                    'delete',
                    'Deleted ' . strtolower($this->getLogPrefix()) . ' item: '
                        . $barang->nama_barang . ' (' . $jumlah . ' units)',
                    $barang->id_kategori,
                    $barang->nama_barang
                );
            }
        });
    }

    protected function validasiSebelumUpdate(Barang $barang, int $jumlah): void
    {}
}