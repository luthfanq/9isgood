<?php

namespace App\Haramain\Repository;

use App\Models\Penjualan\Penjualan;

class PenjualanRepository implements TransaksiRepositoryInterface
{
    public static function kode(): ?string
    {
        $query = Penjualan::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()){
            return '0001/PJ/'.date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/PJ/".date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        // create penjualan
        // return object penjualan
        $penjualan = Penjualan::query()->create([
            'kode'=>self::kode(),
            'active_cash'=>session('ClosedCash'),
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_bayar,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        // create stock_masuk jenis baik
        $stock_keluar = $penjualan->stockKeluarMorph()->create([
            'kode'=>StockKeluarRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // detail proses
        return self::detailProses($detail, $penjualan, $stock_keluar, 'baik',$data);
    }

    public static function update(object $data, array $detail): ?string
    {
        $penjualan = Penjualan::query()
            ->with(['stockKeluar.stockKeluarDetail'])
            ->find($data->penjualan_id);

        // dd($penjualan->stockKeluarMorph->stockKeluarDetail());

        // rollback inventory
        foreach ($penjualan->penjualanDetail as $row)
        {
            StockInventoryRepository::rollback($row, 'baik', $penjualan->gudang_id, 'stock_keluar');
        }

        // delete penjualan detail
        $penjualan->penjualanDetail()->delete();

        // update Penjualan
        $penjualan->update([
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->customer_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_bayar,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stock_keluar = $penjualan->stockKeluarMorph()->first();

        // delete stock keluar detail
        $penjualan->stockKeluarMorph->stockKeluarDetail()->delete();

        // update stock keluar
        $stock_keluar->update([
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // detail proses
        return self::detailProses($detail, $penjualan, $stock_keluar, 'baik', $data);
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
        return null;
    }

    /**
     * @param array $detail
     * @param Penjualan $penjualan
     * @param $stock_keluar
     * @param object $data
     * @return string|null
     */
    protected static function detailProses(array $detail, Penjualan $penjualan, $stock_keluar, $kondisi,object $data): ?string
    {
        foreach ($detail as $item) {
            $penjualan->penjualanDetail()->create([
                'produk_id' => $item['produk_id'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'diskon' => $item['diskon'],
                'sub_total' => $item['sub_total'],
            ]);

            $stock_keluar->stockKeluarDetail()->create([
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
            ]);

            StockInventoryRepository::create(
                (object)[
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah']
                ],
                $kondisi,
                $data->gudang_id,
                'stock_keluar'
            );
        }

        return $penjualan->id;
    }
}
