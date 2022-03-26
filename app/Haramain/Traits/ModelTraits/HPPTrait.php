<?php namespace App\Haramain\Traits\ModelTraits;

use App\Models\Keuangan\JurnalHPP;

trait HPPTrait
{
    public function hpp()
    {
        return $this->morphMany(JurnalHPP::class, 'stockable_hpp', 'stock_type', 'stock_id');
    }
}
