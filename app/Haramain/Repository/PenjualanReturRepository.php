<?php namespace App\Haramain\Repository;

use App\Models\Penjualan\PenjualanRetur;

class PenjualanReturRepository implements TransaksiRepositoryInterface
{
    public static function kode($kondisi='baik'): ?string
    {
        // query
        $query = PenjualanRetur::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis_retur', $kondisi)
            ->latest('kode');

        $kode = ($kondisi == 'baik') ? 'RB' : 'RR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kode}/".date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/{$kode}/".date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        $penjualanRetur = PenjualanRetur::query()->create([
            'kode'=>self::kode(),
            'active_cash'=>session('ClosedCash'),
            'jenis_retur'=>$data->kondisi,
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stockMasuk = $penjualanRetur->stockMasukMorph()->create([
            'kode'=>StockMasukRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        return self::detailProses($detail, $penjualanRetur, $stockMasuk, $data->kondisi, $data);
    }

    public static function update(object $data, array $detail): ?string
    {
        $penjualanRetur = PenjualanRetur::query()
            ->find($data->penjualan_retur_id);

        // dd();

        // rollback
        foreach ($penjualanRetur->returDetail as $row)
        {
            StockInventoryRepository::rollback($row, $data->kondisi, $penjualanRetur->gudang_id, 'stock_masuk');
        }

        $penjualanRetur->returDetail()->delete();

        $penjualanRetur->update([
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

        $stock_masuk = $penjualanRetur->stockMasukMorph()->first();

        // delete stock masuk detail
        $stock_masuk->stockMasukDetail()->delete();

        // update stock masuk
        $stock_masuk->update([
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);
        return self::detailProses($detail, $penjualanRetur, $stock_masuk, $data->kondisi, $data);
    }

    protected static function detailProses(array $detail, PenjualanRetur $penjualanRetur, $stock_masuk, $kondisi, object $data): ?string
    {
        foreach ($detail as $item)
        {
            $penjualanRetur->returDetail()->create([
                'produk_id' => $item['produk_id'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'diskon' => $item['diskon'],
                'sub_total' => $item['sub_total'],
            ]);

            $stock_masuk->stockMasukDetail()->create([
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
                'stock_masuk'
            );
        }
        return $penjualanRetur->id;
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
