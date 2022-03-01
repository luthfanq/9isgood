<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Stock\StockMasuk;

trait StockMasukTraits
{
    public function stockMasuk()
    {
        return $this->morphOne(StockMasuk::class, 'stockable_masuk', 'stockable_masuk_type', 'stockable_masuk_id');
    }
}
