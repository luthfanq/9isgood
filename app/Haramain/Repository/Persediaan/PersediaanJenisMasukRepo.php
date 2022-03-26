<?php namespace App\Haramain\Repository\Persediaan;

use App\Haramain\Repository\PersediaanPerpetualRepo;
use App\Haramain\Repository\PersediaanTransaksiRepo;

class PersediaanJenisMasukRepo
{
    public static function store(object $persediaanTransaksi, $debet, $gudang, $detail):void
    {
        $persediaan_transaksi = $persediaanTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>PersediaanTransaksiRepo::kode(),
            'jenis'=>'masuk', // masuk atau keluar
            'debet'=>$debet,
            'kredit'=>0,
        ]);

        foreach ($detail as $row){
            $persediaan_transaksi->persediaan_transaksi_detail()->create([
                'produk_id'=>$row['produk_id'],
                'harga'=>$row['harga_setelah_diskon'],
                'jumlah'=>$row['jumlah'],
                'sub_total'=>$row['harga_setelah_diskon'] * $row['jumlah'],
            ]);

            PersediaanPerpetualRepo::store($row, 'masuk', $gudang, 'baik');
        }
    }

    public static function rollback(object $persediaanTransaksi, $debet, $gudang, $detail):void
    {
        $persediaan_transaksi = $persediaanTransaksi->update([
            'jenis'=>'masuk', // masuk atau keluar
            'debet'=>$debet,
            'kredit'=>0,
        ]);
    }
}
