<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Purchase\Pembelian;

trait PembelianTraits
{
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }
}
