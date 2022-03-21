<?php

namespace App\Models\Stock;

use App\Haramain\Traits\ModelTraits\{GudangTraits, ProdukTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInventory extends Model
{
    use HasFactory, GudangTraits, ProdukTraits;

    protected $table = 'stock_inventory';
    protected $fillable = [
        'active_cash',
        'jenis',
        'gudang_id',
        'produk_id',
        'stock_awal',
        'stock_opname',
        'stock_masuk',
        'stock_keluar',
        'stock_akhir',
        'stock_lost',
    ];
}
