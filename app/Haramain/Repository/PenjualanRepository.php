<?php

namespace App\Haramain\Repository;

use App\Haramain\Repository\StockInventoryRepository;
use App\Models\Sales\Penjualan;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenjualanRepository
{
    protected static function kode(): ?string
    {
        return null;
    }

    public static function create(object $data, array $detail): ?string
    {
        // create penjualan
        // return object penjualan
        $penjualan = Penjualan::query()->create([
            'kode'=>self::kode(),
            'active_cash'=>session('ClosedCash'),
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->customer_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>$data->tgl_nota,
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? $data->tgl_tempo : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_bayar,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        // create stock_masuk jenis baik
        $stock_keluar = $penjualan->stockKeluar()->create();

        // detail proses
        foreach ($detail as $item)
        {
            $penjualan->penjualanDetail()->create([
                'produk_id'=>$item->produk_id,
                'harga'=>$item->harga,
                'jumlah'=>$item->jumlah,
                'diskon'=>$item->diskon,
                'sub_total'=>$item->sub_total,
            ]);

            $stock_keluar->stockKeluarDetail()->create([
                'produk_id'=>$item->produk_id,
                'jumlah'=>$item->jumlah,
            ]);

            StockInventoryRepository::create(
                (object) [
                    'produk_id'=>$item->produk_id,
                    'jumlah'=>$item->jumlah
                ],
                $data->jenis,
                $data->gudang,
                'stock_keluar'
            );
        }

        return $penjualan->id;
    }

    public function update(int $penjualanId, object $data, array $detail)
    {
        $penjualan = Penjualan::query()->find($penjualanId);

        // update Penjualan
        $penjualan->update([
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->customer_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>$data->tgl_nota,
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? $data->tgl_tempo : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_bayar,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stock_keluar = $penjualan->stockKeluar();

        // update stock keluar
        $stock_keluar->update();


    }
}
