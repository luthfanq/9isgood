<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\PersediaanTransaksi;

class PersediaanTransaksiRepo
{
    public static function kode()
    {
        // query
        $query = PersediaanTransaksi::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()) {
            return '0001/PT/' . date('Y');
        }

        $num = (int)$query->first()->last_num_char + 1 ;
        return sprintf("%04s", $num) . "/PT/" . date('Y');
    }
}
