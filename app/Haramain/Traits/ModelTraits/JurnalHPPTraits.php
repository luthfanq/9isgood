<?php namespace App\Haramain\Traits\ModelTraits;

use App\Models\Keuangan\JurnalHPP;

trait JurnalHPPTraits
{
    public function jurnal_hpp()
    {
        return $this->morphMany(JurnalHPP::class, 'jurnal_type', 'jurnal_id');
    }

    public function stock_hpp()
    {
        return $this->morphMany(JurnalHPP::class, 'stock_type', 'stock_id');
    }
}
