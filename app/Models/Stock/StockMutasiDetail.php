<?php

namespace App\Models\Stock;

use App\Haramain\Traits\ModelTraits\ProdukTraits;
use App\Haramain\Traits\ModelTraits\StockMutasiTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutasiDetail extends Model
{
    use HasFactory, StockMutasiTraits, ProdukTraits;

    protected $table = 'stock_mutasi_detail';
    protected $fillable = [
        'stock_mutasi_id',
        'produk_id',
        'jumlah',
    ];
}
