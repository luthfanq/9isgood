<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\SaldoPiutangPenjualan;

class SaldoPiutangPenjualanRepository
{
    public static function decrement($customer_id, $tanggal, $nominal)
    {
        // check customer_id
        $saldo = SaldoPiutangPenjualan::query()->where('customer_id', $customer_id)->first();
        // check saldo
        if ($saldo->saldo == $nominal){
            return $saldo->update([
                'tgl_akhir'=>tanggalan_database_format($tanggal, 'd-M-Y'),
                'saldo'=>0
            ]);
        }
        return $saldo->decrement('saldo', $nominal);
    }

    public static function increment($customer_id, $tanggal, $nominal)
    {
        // check customer_id
        $saldo = SaldoPiutangPenjualan::query()->where('customer_id', $customer_id);

        if ($saldo->exists()){
            $saldo = $saldo->first();
            if ($saldo->saldo == 0)
            {
                return $saldo->update([
                    'tgl_awal'=>tanggalan_database_format($tanggal, 'd-M-Y'),
                    'saldo'=>$nominal
                ]);
            }
            return $saldo->increment('saldo', $nominal);
        }
        return SaldoPiutangPenjualan::query()->create([
            'customer_id'=>$customer_id,
            'tgl_awal'=>tanggalan_database_format($tanggal, 'd-M-Y'),
            'tgl_akhir'=>null,
            'saldo'=>$nominal
        ]);
    }
}
