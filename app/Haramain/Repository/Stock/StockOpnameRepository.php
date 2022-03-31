<?php namespace App\Haramain\Repository\Stock;

use App\Haramain\Repository\TransaksiRepositoryInterface;
use App\Models\Stock\StockOpname;

class StockOpnameRepository implements TransaksiRepositoryInterface
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

        $num = (int)$query->first()->last_num + 1 ;
        return sprintf("%04s", $num)."/{$kode}/".date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        $stock_opname = StockOpname::query()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>self::kode($data->jenis),
            'jenis'=>$data->jenis,
            'tgl_input'=>$data->tgl_input,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>$data->user_id,
            'pegawai_id'=>$data->pegawai_id,
            'keterangan'=>$data->keterangan,
        ]);

        // store persediaanOpname
        $persediaan_opname = $stock_opname->persediaanOpname()->create([
            'kode',
            'active_cash',
            'kondisi',
            'gudang_id',
            'stock_opname_id',
            'user_id',
            'keterangan',
        ]);

        foreach ($detail as $item) {
            $stock_opname->stockOpnameDetail()->create([
                'produk_id'=>$item->produk_id,
                'jumlah'=>$item->jumlah,
            ]);

            $harga_hpp = ($item->produk->harga_hpp) ?: $item->produk->harga * $this->diskon_hpp;
            $sub_total = $harga_hpp * $item->jumlah;
            $persediaan_opname->persediaan_opname_detail()->create([
                'produk_id'=>$item->produk_id,
                'jumlah'=>$item->jumlah,
                'harga'=> $harga_hpp,
                'sub_total'=>$sub_total,
            ]);
        }
    }

    public static function update(object $data, array $detail): ?string
    {
        // TODO: Implement update() method.
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
