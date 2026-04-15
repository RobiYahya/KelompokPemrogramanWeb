<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = ['barang_id', 'jumlah', 'tanggal', 'keterangan'];
    protected $table = 'barang_masuk';

    protected $appends = ['formatted_id'];

    public function getFormattedIdAttribute()
    {
        return 'IN' . str_pad($this->id, 2, '0', STR_PAD_LEFT);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
