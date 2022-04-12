<?php namespace App\Haramain\Repository\Saldo;

use App\Models\Keuangan\SaldoHutangPembelian;

class SaldoHutangPembelianRepository
{
    public function find($supplier_id)
    {
        $saldoHutangPembelian = SaldoHutangPembelian::query()->find($supplier_id);
        if ($saldoHutangPembelian){
            return $saldoHutangPembelian;
        }
        return SaldoHutangPembelian::query()->firstOrCreate([
            'supplier_id'=>$supplier_id,
            'saldo'=>0
        ]);
    }
}
