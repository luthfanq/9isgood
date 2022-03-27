<?php namespace App\Haramain\Repository\RepoTraits;

use App\Haramain\Repository\StockKeluarRepository;

trait StockKeluarRepoTraits
{
    protected static function storeStockKeluar(object $dataClass, $data)
    {
        $stock_keluar = $dataClass->create([
            'kode'=>StockKeluarRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        $stock_keluar->hpp()->create([
            'active_cash'=>session('ClosedCash'),
            'type'=>'debet', // debet/kredit
            'nominal_debet',
        ]);

        return $stock_keluar;
    }
}
