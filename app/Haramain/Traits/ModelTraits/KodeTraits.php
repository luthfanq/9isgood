<?php

namespace App\Haramain\Traits\ModelTraits;

trait KodeTraits
{
    public function getLastNumMasterAttribute()
    {
        return substr($this->kode, 1, 5);
    }
}
