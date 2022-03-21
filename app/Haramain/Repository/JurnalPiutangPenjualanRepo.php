<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\JurnalPiutangPenjualan;

class JurnalPiutangPenjualanRepo implements TransaksiRepositoryInterface
{
    public static function getNominalSaldo($customer_id)
    {
        $jurnalKas = JurnalPiutangPenjualan::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('customer_id', $customer_id)
            ->latest('kode');
        if ($jurnalKas->doesntExist()){
            return 0;
        }
        return $jurnalKas->first()->nominal_saldo;
    }

    public static function kode(): ?string
    {
        $jurnalPiutangPenjualan = JurnalPiutangPenjualan::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');
        if ($jurnalPiutangPenjualan->doesntExist()){
            return '1/JPPJ/'.date('Y');
        }
        return $jurnalPiutangPenjualan->first()->last_num_char +1 .'/JPPJ/'.date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        // TODO: Implement create() method.
    }

    public static function update(object $data, array $detail): ?string
    {
        // TODO: Implement update() method.
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
