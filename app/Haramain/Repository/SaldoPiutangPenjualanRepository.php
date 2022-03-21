<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\SaldoPiutangPenjualan;

class SaldoPiutangPenjualanRepository
{
    public static function decrement($customer_id, $nominal)
    {
        // check customer_id
        $saldo = SaldoPiutangPenjualan::query()->where('customer_id', $customer_id)->first();
        return $saldo->decrement('saldo', $nominal);
    }

    public static function increment($customer_id, $nominal)
    {
        // check customer_id
        $saldo = SaldoPiutangPenjualan::query()->where('customer_id', $customer_id);

        if ($saldo->exists()){
            $saldo = $saldo->first();
            return $saldo->increment('saldo', $nominal);
        }
        return SaldoPiutangPenjualan::query()->create([
            'customer_id'=>$customer_id,
            'saldo'=>$nominal
        ]);
    }
}
