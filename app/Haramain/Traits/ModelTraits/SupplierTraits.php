<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Master\Supplier;

trait SupplierTraits
{
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
