<?php

namespace App\Models\Sales;

use App\Haramain\Traits\ModelTraits\{PenjualanTraits, ProdukTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory, PenjualanTraits, ProdukTraits;

    protected $table = 'penjualan_detail';
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'harga',
        'jumlah',
        'diskon',
        'sub_total',
    ];
}
