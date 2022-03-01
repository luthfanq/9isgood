<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Stock\StockKeluar;

trait StockKeluarTraits
{
    public function stockKeluarMorph()
    {
        return $this->morphOne(StockKeluar::class, 'stockable_keluar', 'stockable_keluar_type', 'stockable_keluar_id');
    }

    public function stockKeluar()
    {
        return $this->belongsTo(StockKeluar::class, 'stock_keluar_id');
    }
}
