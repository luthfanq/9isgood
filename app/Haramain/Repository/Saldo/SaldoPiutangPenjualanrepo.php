<?php namespace App\Haramain\Repository\Saldo;

use App\Models\Keuangan\SaldoPiutangPenjualan;

class SaldoPiutangPenjualanrepo
{
    public function find($customer_id)
    {
        $saldoPiutang = SaldoPiutangPenjualan::query()->find($customer_id);
        if ($saldoPiutang->doesntExist()){
            return SaldoPiutangPenjualan::query()->create([
                'customer_id'=>$customer_id,
                'saldo'=>0
            ]);
        }
        return $saldoPiutang;
    }

    public function update($data)
    {
        //
    }

    public function rollback()
    {
        //
    }
}
