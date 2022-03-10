<?php namespace App\Haramain\Repository;

use App\Models\Purchase\Pembelian;

class PembelianRepository implements TransaksiRepositoryInterface
{

    public static function kode(): ?string
    {
        // query
        $query = Pembelian::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()) {
            return '0001/PB/' . date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num) . "/PB/" . date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        $pembelian = Pembelian::query()->create([
            'kode'=>self::kode(),
            'active_cash'=>session('ClosedCash'),
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stockMasuk = $pembelian->stockMasukMorph()->create([
            'kode'=>StockMasukRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);
        return self::detailProses($detail, $pembelian, $stockMasuk, 'baik', $data);
    }

    public static function update(object $data, array $detail): ?string
    {
        $pembelian = Pembelian::query()
            ->find($data->pembelian_id);

        // rollback
        foreach ($pembelian->returDetail as $row)
        {
            StockInventoryRepository::rollback($row, 'baik', $pembelian->gudang_id, 'stock_masuk');
        }

        $pembelian->pembelianDetail()->delete();

        $pembelian->update([
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stock_masuk = $pembelian->stockMasukMorph()->first();

        $stock_masuk->stockMasukDetail()->delete();

        $stock_masuk->update([
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);
        return self::detailProses($detail, $pembelian, $stock_masuk, 'baik', $data);
    }

    protected static function detailProses(array $detail, Pembelian $pembelian, $stock_masuk, $kondisi, object $data): ?string
    {
        foreach ($detail as $item)
        {
            $pembelian->pembelianDetail()->create([
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
        return $pembelian->id;
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
