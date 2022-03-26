<?php namespace App\Haramain\Repository\Pembelian;

use App\Models\Keuangan\SaldoHutangPembelian;

class HutangPembelianRepo
{
    public static function store($supplier_id, $pembelian_id, $total_bayar):void
    {
        $query = SaldoHutangPembelian::query()->where('supplier_id', $supplier_id);

        if ($query->doesntExist()){
            // create saldo_hutang_pembelian
            $saldo_hutang_pembelian = SaldoHutangPembelian::query()->create([
                'supplier_id'=>$supplier_id,
                'saldo'=>$total_bayar
            ]);
            $query = $saldo_hutang_pembelian;
            // add hutang
            $query->hutang_pembelian()->create([
                'pembelian_id'=>$pembelian_id,
                'status_bayar'=>'belum',
                'total_bayar'=>$total_bayar,
                'kurang_bayar'=>0
            ]);
        } else {
            // update saldo
            $query->increment('saldo', $total_bayar);
            // add hutang
            $query->first()->hutang_pembelian()->create([
                'pembelian_id'=>$pembelian_id,
                'status_bayar'=>'belum',
                'total_bayar'=>$total_bayar,
                'kurang_bayar'=>0
            ]);
        }
    }

    public static function rollback($supplier_id, $total_bayar)
    {
        $saldo_hutang_pembelian = SaldoHutangPembelian::query()->find($supplier_id);
        $saldo_hutang_pembelian->decrement('saldo', $total_bayar);
    }
}
