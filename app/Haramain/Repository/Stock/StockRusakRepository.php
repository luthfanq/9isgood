<?php namespace App\Haramain\Repository\Stock;

use App\Haramain\Repository\Jurnal\JurnalPersediaanMutasiRepo;
use App\Models\Stock\StockMutasi;

class StockRusakRepository
{
    public function kode()
    {
        //
    }

    public function store(object $data)
    {
        // initiate
        // stock mutasi store
        $stockMutasi = StockMutasi::query()->create([
            'active_cash'=>session('ClosedCash'),
            'kode',
            'jenis_mutasi'=>'baik_rusak',
            'gudang_asal_id'=>$data->gudang_asal_id,
            'gudang_tujuan_id'=>$data->gudang_tujuan_id,
            'tgl_mutasi'=>tanggalan_database_format($data->tgl_mutasi, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // store masuk dan update inventory
        $stockMasukRusak = (new StockMasukRepo())->storeFromRelation($stockMutasi->stockMasukMorph(), $data);

        // stock keluar baik
        $stockKeluarBaik = (new StockKeluarRepo())->storeFromRelation($stockMutasi->stockKeluarMorph(), $data);

        // initiate jurnal persediaan transaksi
        $JurnalPersediaanMutasi = (new JurnalPersediaanMutasiRepo())->store($stockMutasi->jurnalPersediaanTransaksi(), $data);

        // detail transaksi
        foreach ($data->data_detail as $item) {
            // detail mutasi
            // detail stock masuk
            // detail stock keluar
            // detail persediaan transaksi keluar (berdasarkan fifo)
            // get data persediaan persediaanRepo
            // store data transaksi keluar from get data persediaanRepo
            // persediaan inventoy update (barang baik)
            // detail persediaan transaksi masuk
            // store data transaksi masuk from get data persediaanRepo
            // persediaan inventory update (barang rusak)
        }
        // jurnal transaksi persediaan rusak debet
        // jurnal transaksi persediaan rusak kredit
    }
}
