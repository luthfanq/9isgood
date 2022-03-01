<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Purchase\PembelianRetur;

trait PembelianReturTraits
{
    public function pembelianRetur()
    {
        return $this->belongsTo(PembelianRetur::class, 'pembelian_retur_id');
    }
}
