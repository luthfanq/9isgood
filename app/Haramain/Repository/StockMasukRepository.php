<?php namespace App\Haramain\Repository;

use App\Models\Stock\StockMasuk;

class StockMasukRepository implements TransaksiRepositoryInterface
{

    public static function kode($kondisi = 'baik'): ?string
    {
        // query
        $query = StockMasuk::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'SK' : 'SKR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kodeKondisi}/".date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        $stock_masuk = StockMasuk::query()->create([
            'kode'=>self::kode($data->kondisi),
            'active_cash'=>session('ClosedCash'),
            'stockable_masuk_id'=>null,
            'stockable_masuk_type'=>null,
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id ?? $data->gudang_masuk,
            'supplier_id'=>$data->supplier_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_masuk, 'd-M-Y'),
            'user_id'=>auth()->id(),
            'nomor_po'=>$data->nomor_po ?? null,
            'keterangan'=>$data->keterangan,
        ]);

        foreach ($detail as $row){
            $stock_masuk->stockMasukDetail()->create([
                'produk_id'=>$row->produk->id,
                'jumlah'=>$row->jumlah,
            ]);

            StockInventoryRepository::create(
                (object)[
                    'produk_id' => $row['produk_id'],
                    'jumlah' => $row['jumlah']
                ],
                $data->kondisi,
                $data->gudang_id,
                'stock_masuk'
            );
        }

        return $stock_masuk->id;
    }

    public static function update(object $data, array $detail): ?string
    {
        $stock_masuk = StockMasuk::query()->find($data->stock_masuk_id);

        foreach ($stock_masuk->stockMasukDetail as $row){
            StockInventoryRepository::rollback($row, $data->kondisi, $stock_masuk->gudang_id, 'stock_masuk');
        }

        $stock_masuk->stockMasukDetail()->delete();

        $stock_masuk->update([
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_masuk, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        foreach ($detail as $row){
            $stock_masuk->stockMasukDetail()->create([
                'produk_id'=>$row->produk->id,
                'jumlah'=>$row->jumlah,
            ]);

            StockInventoryRepository::create(
                (object)[
                    'produk_id' => $row['produk_id'],
                    'jumlah' => $row['jumlah']
                ],
                $data->kondisi,
                $data->gudang_id,
                'stock_masuk'
            );
        }

        return $stock_masuk->id;
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
