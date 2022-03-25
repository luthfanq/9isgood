<?php namespace App\Haramain\Traits\ModelTraits;

use App\Models\Keuangan\Akun;

trait AkunTrait
{
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
