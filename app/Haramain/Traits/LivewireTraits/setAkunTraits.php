<?php namespace App\Haramain\Traits\LivewireTraits;

use App\Models\Keuangan\Akun;

trait SetAkunTraits
{
    public $akun_id, $akun_nama, $deskripsi;

    public function setAkun(Akun $akun)
    {
        $this->akun_id = $akun->id;
        $this->akun_nama = $akun->deskripsi;
    }
}
