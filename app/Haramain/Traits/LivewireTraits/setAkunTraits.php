<?php namespace App\Haramain\Traits\LivewireTraits;

use App\Models\Keuangan\Akun;

trait SetAkunTraits
{
    public $akun_id, $deskripsi;

    public function setAkun(Akun $akun)
    {
        $this->akun_id = $akun->id;
        $this->akunNama = $akun->deskripsi;
    }
}
