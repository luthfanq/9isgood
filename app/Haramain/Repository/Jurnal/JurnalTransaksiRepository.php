<?php namespace App\Haramain\Repository\Jurnal;

class JurnalTransaksiRepository
{
    public function storeDebet(object $jurnalTransaksi, $akun_id, $nominalDebet)
    {
        return $jurnalTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$akun_id,
            'nominal_debet'=>$nominalDebet,
        ]);
    }

    public function storeKredit(object $jurnalTransaksi, $akun_id, $nominalKredit)
    {
        return $jurnalTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$akun_id,
            'nominal_kredit'=>$nominalKredit,
        ]);
    }

    public function rollback(object $jurnalTransaksi)
    {
        return $jurnalTransaksi->delete();
    }
}
