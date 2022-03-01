<?php

namespace App\Models\Sales;

use App\Haramain\Traits\ModelTraits\{PenjualanReturTraits, ProdukTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanReturDetail extends Model
{
    use HasFactory, ProdukTraits, PenjualanReturTraits;

    protected $table = 'penjualan_retur_detail';
    protected $fillable = [
        'penjualan_retur_id',
        'produk_id',
        'harga',
        'jumlah',
        'diskon',
        'sub_total',
    ];
}
