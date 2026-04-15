<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $fillable = ['barang_id', 'jumlah', 'tanggal', 'keterangan'];
    protected $table = 'barang_keluar';

    protected $appends = ['formatted_id'];

    public function getFormattedIdAttribute()
    {
        return 'OUT' . str_pad($this->id, 2, '0', STR_PAD_LEFT);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
