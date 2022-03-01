<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Master\Gudang;

trait GudangTraits
{
    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function gudangAsal()
    {
        return $this->belongsTo(Gudang::class, 'gudang_asal_id');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(Gudang::class, 'gudang_tujuan_id');
    }
}
