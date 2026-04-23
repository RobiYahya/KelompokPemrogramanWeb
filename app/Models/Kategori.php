<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama'];
    protected $table = 'kategori';

    protected $appends = ['formatted_id'];

    public function getFormattedIdAttribute()
    {
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $this->nama), 0, 3));
        if (strlen($prefix) < 3) {
            $prefix = str_pad($prefix, 3, 'X');
        }
        return $prefix . str_pad($this->id, 2, '0', STR_PAD_LEFT);
    }

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
