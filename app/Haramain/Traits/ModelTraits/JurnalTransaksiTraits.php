<?php namespace App\Haramain\Traits\ModelTraits;

use App\Models\Keuangan\JurnalTransaksi;

trait JurnalTransaksiTraits
{
    public function jurnal_transaksi()
    {
        return $this->morphMany(JurnalTransaksi::class, 'jurnalable_kas', 'jurnal_type', 'jurnal_id');
    }
}
