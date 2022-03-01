<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Master\Pegawai;

trait PegawaiTraits
{
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
