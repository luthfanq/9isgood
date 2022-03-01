<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Master\Produk;

trait ProdukTraits
{
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
