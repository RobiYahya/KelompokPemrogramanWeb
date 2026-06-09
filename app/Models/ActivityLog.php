<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // Sesuai tabel histori_aktivitas di database
    protected $table = 'histori_aktivitas';
    protected $primaryKey = 'id_histori';

    protected $fillable = [
        'id_user',
        'causer_name',
        'aksi',
        'id_kategori',
        'nama_barang',
        'deskripsi',
    ];

    // histori_aktivitas is an append-only audit log — no updated_at column
    const CREATED_AT = 'tanggal';
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public static function log(
        string $aksi,
        string $deskripsi,
        ?int $idKategori = null,
        ?string $namaBarang = null
    ): void {
        static::create([
            'id_user'     => auth()->id(),
            'causer_name' => auth()->user()?->nama,
            'aksi'        => $aksi,
            'id_kategori' => $idKategori,
            'nama_barang' => $namaBarang,
            'deskripsi'   => $deskripsi,
        ]);
    }
}
