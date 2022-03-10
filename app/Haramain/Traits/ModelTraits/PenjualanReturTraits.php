<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Penjualan\PenjualanRetur;

trait PenjualanReturTraits
{
    public function penjualanRetur()
    {
        return $this->belongsTo(PenjualanRetur::class, 'penjualan_retur_id');
    }
}
