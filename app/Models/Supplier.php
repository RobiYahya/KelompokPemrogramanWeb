<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';

    // id_divisi dihapus — tabel divisi tidak ada di ERD & database
    protected $fillable = ['nama_supplier', 'divisi', 'kontak', 'no_telp', 'alamat'];

    protected $appends = ['formatted_id'];

    public function getFormattedIdAttribute()
    {
        $prefix = strtolower(substr(preg_replace('/[^a-zA-Z]/', '', $this->nama_supplier), 0, 3));
        if (strlen($prefix) < 3) {
            $prefix = str_pad($prefix, 3, 'x');
        }
        return $prefix . str_pad($this->id_supplier, 2, '0', STR_PAD_LEFT);
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_supplier', 'id_supplier');
    }
}