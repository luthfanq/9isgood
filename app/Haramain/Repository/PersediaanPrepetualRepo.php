<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\PersediaanPerpetual;

class PersediaanPrepetualRepo
{
    public static function kode()
    {
        return null;
    }

    // store persediaan
    protected static function store($data): \Illuminate\Database\Eloquent\Builder
    {
         return PersediaanPerpetual::query()->create([
            'active_cash'=>session('ClosedCash'),
            'stock_awal'=>$data->stock_awal ?? null,
            'kode'=>self::kode(),
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id,
            'produk_id'=>$data->produk_id,
            'harga'=>$data->harga,
            'jumlah'=>$data->jumlah,
            'sub_total'=>$data->sub_total,
        ]);
    }

    protected static function query($data): \Illuminate\Database\Eloquent\Builder
    {
        return PersediaanPerpetual::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('kondisi', $data->kondisi)
            ->where('gudang_id', $data->gudang_id)
            ->where('produk_id', $data->produk_id)
            ->where('harga');
    }

    // update persediaan increment
    public static function updateOrCreateMasuk($data): \Illuminate\Database\Eloquent\Builder|int
    {
        $query = self::query($data);

        if ($query->doesntExist()){
            return self::store($data);
        }
        return $query->increment('jumlah', $data->jumlah);
    }

    // update persediaan decrement
    public static function updateOrCreateKeluar($data): \Illuminate\Database\Eloquent\Builder|int
    {
        $query = self::query($data);

        if ($query->doesntExist()){
            return self::store($data);
        }
        return $query->decrement('jumlah', $data->jumlah);
    }

    // rollback persediaan masuk
    public static function rollbackMasuk($data): int
    {
        return self::query($data)->decrement('jumlah', $data->jumlah);
    }

    //
    public static function rollbackKeluar($data): int
    {
        return self::query($data)->increment('jumlah', $data->jumlah);
    }
}
