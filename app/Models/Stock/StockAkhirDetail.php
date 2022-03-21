<?php

namespace App\Models\Stock;

use App\Haramain\Traits\ModelTraits\ProdukTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAkhirDetail extends Model
{
    use HasFactory, ProdukTraits;
    protected $table = 'stock_akhir_detail';
    protected $fillable = [
        'stock_akhir_id',
        'produk_id',
        'jumlah'
    ];

    public function stock_akhir()
    {
        return $this->belongsTo(StockAkhir::class, 'stock_akhir_id');
    }
}
