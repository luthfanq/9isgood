<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Stock\StockKeluar;

trait StockKeluarTraits
{
    public function stockKeluar()
    {
        return $this->morphOne(StockKeluar::class, 'stockable_keluar', 'stockable_keluar_type', 'stockable_keluar_id');
    }
}
