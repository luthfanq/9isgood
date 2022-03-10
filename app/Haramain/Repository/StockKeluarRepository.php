<?php namespace App\Haramain\Repository;

use App\Models\Stock\StockKeluar;

class StockKeluarRepository implements TransaksiRepositoryInterface
{
    //
    public static function kode($kondisi='baik'): ?string
    {
        // query
        $query = StockKeluar::query()
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
        $stock_keluar = StockKeluar::query()->create([
            'kode'=>self::kode($data->kondisi),
            'supplier_id'=>$data->supplier->id,
            'active_cash'=>session('ClosedCash'),
            'stockable_keluar_id'=>null,
            'stockable_keluar_type'=>null,
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id ?? $data->gudang_keluar,
            'tgl_keluar'=>tanggalan_database_format('tgl_keluar', 'd-M-Y'),
            'user_id'=>auth()->id(),
            'keterangan'=>$data->keterangan,
        ]);

        foreach ($detail as $row){
            $stock_keluar->stockKeluarDetail()->create([
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
                'stock_keluar'
            );
        }

        return $stock_keluar->id;
    }

    public static function update(object $data, array $detail): ?string
    {
        $stock_keluar = StockKeluar::query()->find($data->stock_keluar_id);

        foreach ($stock_keluar->stockKeluarDetail() as $row){
            StockInventoryRepository::rollback($row, $data->kondisi, $stock_keluar->gudang_id, 'stock_masuk');
        }

        $stock_keluar->stockKeluarDetail()->delete();

        $stock_keluar->update([
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_keluar, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        foreach ($detail as $row){
            $stock_keluar->stockKeluarDetail()->create([
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
                'stock_keluar'
            );
        }

        return $stock_keluar->id;
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
