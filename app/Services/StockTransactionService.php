<?php

namespace App\Services;

use App\Contracts\StockTransactionInterface;
use Illuminate\Http\Request;

class StockTransactionService
{
    public function __construct(
        private StockTransactionInterface $transaksi
    ) {}

    public function store(Request $request): void
    {
        // Delegasi sepenuhnya ke implementasi yang diinjeksikan
        $this->transaksi->store($request);
    }

    public function update(array $validated, $transaction): void
    {
        $this->transaksi->update($validated, $transaction);
    }

    public function destroy($transaction): void
    {
        $this->transaksi->destroy($transaction);
    }
}