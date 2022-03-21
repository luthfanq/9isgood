<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\JurnalKas;

class JurnalKasRepository implements TransaksiRepositoryInterface
{
    public static function getNominalSaldo($akun_id)
    {
        $jurnalKas = JurnalKas::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('akun_id', $akun_id)
            ->latest('kode');
        if ($jurnalKas->doesntExist()){
            return 0;
        }
        return $jurnalKas->first()->nominal_saldo;
    }

    public static function kode(): ?string
    {
        $jurnalKas = JurnalKas::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');
        if ($jurnalKas->doesntExist()){
            return '1/JKAS/'.date('Y');
        }
        return $jurnalKas->first()->last_num_char +1 .'/JKAS/'.date('Y');
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
