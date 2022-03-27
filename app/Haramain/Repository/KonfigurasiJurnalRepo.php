<?php namespace App\Haramain\Repository;

use App\Models\KonfigurasiJurnal;

class KonfigurasiJurnalRepo
{
    public static function getAkunId($id)
    {
        return KonfigurasiJurnal::query()->find($id)->akun_id;
    }
}
