<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;
    protected $table = 'akun';
    protected $fillable = [
        'akun_kategori_id',
        'akun_tipe_id',
        'kode',
        'deskripsi',
        'keterangan',
    ];

    public function akunKategori()
    {
        return $this->belongsTo(AkunKategori::class, 'akun_kategori_id');
    }

    public function akunTipe()
    {
        return $this->belongsTo(AkunTipe::class, 'akun_tipe_id');
    }
}
