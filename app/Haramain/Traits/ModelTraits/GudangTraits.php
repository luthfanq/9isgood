<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Master\Gudang;

trait GudangTraits
{
    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }
}
