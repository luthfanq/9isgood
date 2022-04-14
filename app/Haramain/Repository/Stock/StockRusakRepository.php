<?php namespace App\Haramain\Repository\Stock;

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

        // stock masuk rusak
        $stockMasukRusak = $stockMutasi->stockMasukMorph()->create([
            'kode',
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'rusak',
            'gudang_id'=>$data->gudang_tujuan_id,
            'supplier_id'=>$data->supplier_id ?? null,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_mutasi, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'nomor_po'=>null,
            'nomor_surat_jalan'=>$data->nomor_surat_jalan,
            'keterangan'=>$data->keterangan,
        ]);

        // stock keluar baik
        $stockKeluarBaik = $stockMutasi->stockKeluarMorph()->create([
            'kode',
            'supplier_id'=>$data->supplier_id ?? null,
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_asal_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_mutasi, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // initiate jurnal persediaan transaksi
        $JurnalPersediaanMutasi = $stockMutasi->jurnalPersediaanTransaksi()->create([
            'active_cash'=>session('ClosedCash'),
            'kode',
            'gudang_asal_id'=>$data->gudang_asal_id,
            'gudang_tujuan_id'=>$data->gudang_tujuan_id,
            'jenis'=>'baik_rusak',
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);
        // persediaan transaksi masuk
        $persediaanTransaksi = $JurnalPersediaanMutasi->persediaanTransaksi();
        $persediaanMasuk = $persediaanTransaksi->create();
        // persediaan transaksi keluar
        $persediaanKeluar = $persediaanTransaksi->create();

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
