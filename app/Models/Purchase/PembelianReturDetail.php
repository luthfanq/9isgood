<?php

namespace App\Models\Purchase;

use App\Haramain\Traits\ModelTraits\PembelianReturTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianReturDetail extends Model
{
    use HasFactory, PembelianReturTraits;
    protected $table = 'pembelian_retur_detail';
    protected $fillable = [
        'pembelian_retur_id',
        'produk_id',
        'harga',
        'jumlah',
        'diskon',
        'sub_total',
    ];
}
