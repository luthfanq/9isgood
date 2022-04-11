<?php namespace App\Haramain\Repository\Saldo;

use App\Models\Keuangan\SaldoPiutangPenjualan;

class SaldoPiutangPenjualanrepo
{
    public function find($customer_id)
    {
        $saldoPiutang = SaldoPiutangPenjualan::query()->where('customer_id', $customer_id);
        if ($saldoPiutang->doesntExist()){
            //dd($saldoPiutang);
            return SaldoPiutangPenjualan::query()->create([
                'customer_id'=>$customer_id,
                'saldo'=>0
            ]);
        }
        return $saldoPiutang->first();
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
