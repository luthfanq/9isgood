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
            ->where('harga' ,($kondisi == 'rusak'||$jenis =='keluar') ?  0 - $data['harga_setelah_diskon'] : $data['harga_setelah_diskon']);

        if ($query->count() == 0){
            return PersediaanPerpetual::query()->create([
                'active_cash'=>session('ClosedCash'),
                'jenis'=>$jenis,
                'kondisi'=>$kondisi,
                'gudang_id'=>$gudang,
                'produk_id'=>$data['produk_id'],
                'harga'=>($kondisi == 'rusak'||$jenis =='keluar') ?  0 - $data['harga_setelah_diskon'] : $data['harga_setelah_diskon'],
                'jumlah'=>$data['jumlah'],
            ]);
        }

        return $query->increment('jumlah', $data['jumlah']);
    }

    public static function rollback(object $data, $jenis, $gudang, $kondisi)
    {
        $harga_setelah_diskon = (int) $data->harga - ($data->harga * ((int) $data->diskon)/100);
        $query = PersediaanPerpetual::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $jenis) // masuk atau keluar
            ->where('kondisi', $kondisi)
            ->where('gudang_id', $gudang)
            ->where('produk_id', $data->produk_id)
            ->where('harga' ,($kondisi == 'rusak'||$jenis =='keluar') ?  0 - $harga_setelah_diskon : $harga_setelah_diskon);
//        return $query->count();
        return $query->decrement('jumlah', $data->jumlah);
    }

}
