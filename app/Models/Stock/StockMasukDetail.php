<?php

namespace App\Models\Stock;

use App\Haramain\Traits\ModelTraits\ProdukTraits;
use App\Haramain\Traits\ModelTraits\StockMasukTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMasukDetail extends Model
{
    use HasFactory, StockMasukTraits, ProdukTraits;

    protected $table = 'stock_masuk_detail';
    protected $fillable = [
        'stock_masuk_id',
        'produk_id',
        'jumlah',
    ];
}
