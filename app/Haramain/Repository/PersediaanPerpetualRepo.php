<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\PersediaanPerpetual;

class PersediaanPerpetualRepo
{
    // prinsip FIFO

    // simpan data increment
    public static function store(array $data, $jenis, $gudang, $kondisi)
    {
        $query = PersediaanPerpetual::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $jenis) // masuk atau keluar
            ->where('kondisi', $kondisi)
            ->where('gudang_id', $gudang)
            ->where('produk_id', $data['produk_id'])
            ->where('harga' ,($kondisi == 'rusak') ?  0 - $data['harga'] : $data['harga']);

        if ($query->doesntExist()){
            return PersediaanPerpetual::query()->create([
                'active_cash'=>session('ClosedCash'),
                'kondisi'=>$kondisi,
                'gudang_id'=>$gudang,
                'produk_id'=>$data['produk_id'],
                'harga'=>($kondisi == 'rusak') ?  0 - $data['harga'] : $data['harga'],
                'jumlah'=>$data['jumlah'],
            ]);
        }

        return $query->increment('jumlah', $data['jumlah']);
    }

    public static function rollback(array $data, $jenis, $gudang, $kondisi)
    {
        $query = PersediaanPerpetual::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $jenis) // masuk atau keluar
            ->where('kondisi', $kondisi)
            ->where('gudang_id', $gudang)
            ->where('produk_id', $data['produk_id'])
            ->where('harga' ,($kondisi == 'rusak') ?  0 - $data['harga'] : $data['harga']);
        return $query->decrement('jumlah', $data['jumlah']);
    }

}
