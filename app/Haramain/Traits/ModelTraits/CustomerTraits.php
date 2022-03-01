<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\Master\Customer;

trait CustomerTraits
{
    public function customer()
    {
        return $this->belongTo(Customer::class, 'customer_id');
    }
}
