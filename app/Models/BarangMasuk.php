<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_masuk';

    // Sesuai kolom tabel barang_masuk di database
    protected $fillable = ['id_barang', 'id_user', 'jumlah', 'tanggal', 'deskripsi'];

    protected $appends = ['formatted_id'];

    public function getFormattedIdAttribute()
    {
        return 'IN' . str_pad($this->id_masuk, 3, '0', STR_PAD_LEFT);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
