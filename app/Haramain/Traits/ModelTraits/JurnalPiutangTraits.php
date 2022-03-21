<?php namespace App\Haramain\Traits\ModelTraits;

use App\Models\Keuangan\JurnalPiutangPenjualan;

trait JurnalPiutangTraits
{
    public function jurnal_piutang()
    {
        return $this->morphMany(JurnalPiutangPenjualan::class, 'jurnalable_piutang', 'piutang_type', 'piutang_id');
    }
}
