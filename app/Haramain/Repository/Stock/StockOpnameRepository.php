<?php namespace App\Haramain\Repository\Stock;

use App\Haramain\Repository\TransaksiRepositoryInterface;
use App\Models\Stock\StockOpname;

class StockOpnameRepository
{
    public $diskon_hpp;

    public static function kode($jenis='baik'): ?string
    {
        $query = StockOpname::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $jenis)
            ->latest('kode');

        $kode = ($jenis == 'baik') ? 'SO' : 'SOR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kode}/".date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/{$kode}/".date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        // create stock opname
        $stock_opname = StockOpname::query()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>self::kode($data->jenis),
            'jenis'=>$data->jenis,
            'tgl_input'=>tanggalan_database_format($data->tgl_input, 'd-M-Y'),
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'pegawai_id'=>$data->pegawai_id,
            'keterangan'=>$data->keterangan,
        ]);

        // initiate stock opname detail
        $stock_opname_detail = $stock_opname->stockOpnameDetail();

        foreach ($data->data_detail as $item){
            // store stock opname detail
            $stock_opname_detail->create([
                'produk_id'=>$item['produk_id'],
                'jumlah'=>$item['jumlah'],
            ]);
            // update stock
            (new StockInventoryRepo())->incrementArrayData($item, $data->gudang_id, $data->jenis, 'stock_opname');
        }
        return $stock_opname->id;
    }

    public static function update(object $data, array $detail): ?string
    {
        // initiate
        $stockOpname = StockOpname::query()->find($data->stock_id);
        $stock_opname_detail = $stockOpname->stockOpnameDetail();

        //rollback
        foreach ($stockOpname->stockOpnameDetail as $item){
            (new StockInventoryRepo())->rollback($item, $stockOpname->gudang_id, $stockOpname->jenis, 'stock_opname');
        }
        $stock_opname_detail->delete();

        // update stock opname
        $stockOpname->update([
            'jenis'=>$data->jenis,
            'tgl_input'=>tanggalan_database_format($data->tgl_input, 'd-M-Y'),
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'pegawai_id'=>$data->pegawai_id,
            'keterangan'=>$data->keterangan,
        ]);

        // create new detail
        foreach ($data->data_detail as $item){
            // store stock opname detail
            $stock_opname_detail->create([
                'produk_id'=>$item['produk_id'],
                'jumlah'=>$item['jumlah'],
            ]);
            // update stock
            (new StockInventoryRepo())->incrementArrayData($item, $data->gudang_id, $data->jenis, 'stock_opname');
        }
        return $stockOpname->id;
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
