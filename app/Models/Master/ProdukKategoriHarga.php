<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKategoriHarga extends Model
{
    use HasFactory;

    protected $table = 'produk_kategori_harga';
    protected $fillable = [
        'nama',
        'keterangan',
    ];
}
