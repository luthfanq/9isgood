<?php

namespace App\Haramain\Repository;

use App\Models\Stock\StockInventory;

class StockInventoryRepository
{
    /**
     * Insert or Update Data Stock Inventory
     * @param $data
     * @param $jenis
     * @param $gudang
     * @param $column
     * @return string|null
     */
    public static function create($data, $jenis, $gudang, $column): ?string
    {
        $query = StockInventory::query()
            ->where('produk_id', $data->produk_id)
            ->where('jenis', $jenis)
            ->where('gudang_id', $gudang)
            ->where('active_cash', session('ClosedCash'));
        if ($query->count() > 0){
            // update Stock
            return $query->update([
                $column=>\DB::raw($column.' +'.$data->jumlah)
            ]);
        } else {
            return StockInventory::query()->create([
                'active_cash'=>session('ClosedCash'),
                'jenis'=>$jenis,
                'gudang_id'=>$gudang,
                'produk_id'=>$data->produk_id,
                $column=>$data->jumlah
            ]);
        }
    }

    /**
     * mengembalikan nilai sebelum adanya transaksi
     * @param $data
     * @param $jenis
     * @param $gudang
     * @param $column
     * @return string|null
     */
    public static function rollback($data, $jenis, $gudang, $column): ?string
    {
        return StockInventory::query()
            ->where('produk_id', $data->produk_id)
            ->where('jenis', $jenis)
            ->where('gudang_id', $gudang)
            ->where('active_cash', session('ClosedCash'))
            ->update([
                $column=>\DB::raw($column.' -'.$data->jumlah)
            ]);
    }
}
