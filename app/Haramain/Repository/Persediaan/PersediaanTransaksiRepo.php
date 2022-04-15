<?php namespace App\Haramain\Repository\Persediaan;

use App\Models\Keuangan\PersediaanTransaksi;

class PersediaanTransaksiRepo
{
    public function kode()
    {
        $query = PersediaanTransaksi::query()
            ->where('active_cash', session('ClosedCash'));

        if ($query->doesntExist()){
            return '0001/PD/'.date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/PD/".date('Y');
    }

    public function store(object $persediaanTransaksi, $data)
    {
        $persediaanTransaksi = $persediaanTransaksi->create([
            'active_cash',
            'kode',
            'jenis', // masuk atau keluar
            'kondisi', // baik atau rusak
            'gudang_id',
            'persediaan_type',
            'persediaan_id',
            'debet',
            'kredit',
        ]);
    }
}
