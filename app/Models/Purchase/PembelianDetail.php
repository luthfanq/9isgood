<?php

namespace App\Models\Purchase;

use App\Haramain\Traits\ModelTraits\PembelianTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory, PembelianTraits;
    protected $table = 'pembelian_detail';
    protected $fillable = [
        'pembelian_id',
        'produk_id',
        'harga',
        'jumlah',
        'diskon',
        'sub_total',
    ];
}
