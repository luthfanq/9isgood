<?php namespace App\Haramain\Repository;

use App\Models\Stock\StockAkhir;

class StockAkhirRepository implements TransaksiRepositoryInterface
{
    public static function kode($kondisi='baik'): ?string
    {
        // query
        $query = StockAkhir::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'SA' : 'SAR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kodeKondisi}/".date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        $stock_akhir = StockAkhir::query()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>self::kode($data->kondisi),
            'jenis'=>$data->kondisi,
            'tgl_input'=>tanggalan_database_format($data->tgl_input, 'd-M-Y'),
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'pegawai_id'=>$data->pegawai_id,
            'keterangan'=>$data->keterangan,
        ]);

        $stock_akhir_detail = $stock_akhir->stock_akhir_detail();

        foreach ($detail as $row){
            $stock_akhir_detail->create([
                'produk_id'=>$row['produk_id'],
                'jumlah'=>$row['jumlah']
            ]);

            StockInventoryRepository::create((object)$row, $data->kondisi, $data->gudang_id, 'stock_akhir');
        }
        return $stock_akhir->id;
    }

    public static function update(object $data, array $detail): ?string
    {
        $stock_akhir = StockAkhir::query()->find($data->stock_akhir_id);

        // rollback
        foreach ($stock_akhir->stock_akhir_detail as $item) {
            StockInventoryRepository::rollback($item, $stock_akhir->jenis, $stock_akhir->gudang_id, 'stock_akhir');
        }

        $stock_akhir_detail = $stock_akhir->stock_akhir_detail();

        $stock_akhir_detail->delete();

        $stock_akhir->update([
            'jenis'=>$data->kondisi,
            'tgl_input'=>tanggalan_database_format($data->tgl_input, 'd-M-Y'),
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'pegawai_id'=>$data->pegawai_id,
            'keterangan'=>$data->keterangan,
        ]);

        foreach ($detail as $row){
            $stock_akhir_detail->create([
                'produk_id'=>$row['produk_id'],
                'jumlah'=>$row['jumlah']
            ]);

            StockInventoryRepository::create((object)$row, $data->kondisi, $data->gudang_id, 'stock_akhir');
        }
        return $stock_akhir->id;
    }

    public static function delete(int $id): ?string
    {
        $stock_akhir = StockAkhir::query()->find($id);

        // rollback
        foreach ($stock_akhir->stock_akhir_detail as $item) {
            StockInventoryRepository::rollback((object)$item, $stock_akhir->jenis, $stock_akhir->gudang_id, 'stock_akhir');
        }

        $stock_akhir->stock_akhir_detail()->delete();

        return $stock_akhir->delete();
    }
}
