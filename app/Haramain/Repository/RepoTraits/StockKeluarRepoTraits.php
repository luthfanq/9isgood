<?php namespace App\Haramain\Repository\RepoTraits;

use App\Haramain\Repository\StockKeluarRepository;

trait StockKeluarRepoTraits
{
    protected static function storeStockKeluar(object $dataClass, $data)
    {
        return $dataClass->create([
            'kode'=>StockKeluarRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);
    }
}
