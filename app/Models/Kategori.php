<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];

    protected $appends = ['formatted_id'];

    public function getFormattedIdAttribute()
    {
        $prefix = strtolower(substr(preg_replace('/[^a-zA-Z]/', '', $this->nama_kategori), 0, 3));
        if (strlen($prefix) < 3) {
            $prefix = str_pad($prefix, 3, 'x');
        }
        return $prefix . str_pad($this->id_kategori, 4, '0', STR_PAD_LEFT);
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }
}
