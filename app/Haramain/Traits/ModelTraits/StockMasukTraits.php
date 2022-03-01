<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Stock\StockMasuk;

trait StockMasukTraits
{
    public function stockMasukMorph()
    {
        return $this->morphOne(StockMasuk::class, 'stockable_masuk', 'stockable_masuk_type', 'stockable_masuk_id');
    }

    public function stockMasuk()
    {
        return $this->belongsTo(StockMasuk::class, 'stock_masuk_id');
    }
}
