<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Stock\StockMutasi;

trait StockMutasiTraits
{
    public function stockMutasi()
    {
        return $this->belongsTo(StockMutasi::class);
    }
}
