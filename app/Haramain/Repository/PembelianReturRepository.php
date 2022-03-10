<?php namespace App\Haramain\Repository;

use App\Models\Purchase\PembelianRetur;

class PembelianReturRepository implements TransaksiRepositoryInterface
{

    public static function kode(): ?string
    {
        // query
        $query = PembelianRetur::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()) {
            return '0001/PBR/' . date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num) . "/PBR/" . date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        $pembelianRetur = PembelianRetur::query()->create([
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

        $stock_keluar = $pembelianRetur->stockKeluarMorph()->create([
            'kode'=>StockKeluarRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan
        ]);
        return self::detailProses($detail, $pembelianRetur, $stock_keluar, 'baik', $data);
    }

    public static function update(object $data, array $detail): ?string
    {
        $pembelianRetur = PembelianRetur::query()
            ->find($data->pembelian_id);

        // rollback
        foreach ($pembelianRetur->returDetail as $row)
        {
            StockInventoryRepository::rollback($row, 'baik', $pembelianRetur->gudang_id, 'stock_keluar');
        }

        $pembelianRetur->returDetail()->delete();

        $pembelianRetur->update([
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

        $stock_keluar = $pembelianRetur->stockKeluarMorph()->first();

        $stock_keluar->stockKeluarDetail()->delete();

        $stock_keluar->update([
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);
        return self::detailProses($detail, $pembelianRetur, $stock_keluar, 'baik', $data);
    }

    public static function detailProses(array $detail, PembelianRetur $pembelianRetur, $stock_keluar, $kondisi, object $data)
    {
        foreach ($detail as $item)
        {
            $pembelianRetur->pembelianReturDetail()->create([
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
        return $pembelianRetur->id;
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
