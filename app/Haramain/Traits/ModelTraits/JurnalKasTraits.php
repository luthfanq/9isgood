<?php namespace App\Haramain\Traits\ModelTraits;

use App\Models\Keuangan\JurnalKas;

trait JurnalKasTraits
{
    public function jurnal_kas()
    {
        return $this->morphMany(JurnalKas::class, 'jurnal_kasable', 'cash_type', 'cash_id');
    }
}
