<?php namespace App\Haramain\Repository\Jurnal;

use App\Haramain\Repository\Persediaan\PersediaanRepository;
use App\Haramain\Repository\Persediaan\PersediaanTransaksiRepo;
use App\Models\Keuangan\JurnalPersediaanMutasi;

class JurnalPersediaanMutasiRepo
{
    public function kode($jenis)
    {
        $query = JurnalPersediaanMutasi::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $jenis);

        $kodeJenis = null;

        if ($jenis == 'baik_baik'){
            $kodeJenis = 'JMB';
        }

        if ($jenis == 'baik_rusak'){
            $kodeJenis = 'JMR';
        }

        if ($jenis == 'rusak_rusak'){
            $kodeJenis = 'JMRR';
        }

        if ($query->doesntExist()){
            return '0001/'.$kodeJenis.'/'.date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/".$kodeJenis."/".date('Y');
    }

    public function store(object $jurnalPersediannMutasi, $data)
    {
        // make and initiate $jurnalMutasi
        $jurnalMutasi = $jurnalPersediannMutasi->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>$this->kode($data->jenis),
            'gudang_asal_id'=>$data->gudang_asal_id,
            'gudang_tujuan_id'=>$data->gudang_tujuan_id,
            'stock_mutasi_id'=>$data->stock_mutasi_id,
            'jenis'=>$data->jenis,
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        if ($data->jenis == 'baik_baik'){
            $kondisiMasuk = 'baik';
            $kondisiKeluar = 'baik';
        } elseif ($data->jenis == 'baik_rusak'){
            $kondisiMasuk = 'rusak';
            $kondisiKeluar= 'baik';
        } else {
            $kondisiMasuk = 'rusak';
            $kondisiKeluar= 'rusak';
        }

        // make persediaan transaksi keluar
        $persediaanTransaksiKeluar = $jurnalMutasi->persediaan_transaksi()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>(new PersediaanTransaksiRepo())->kode(),
            'jenis'=>'keluar', // masuk atau keluar
            'kondisi'=>$kondisiKeluar, // baik atau rusak
            'gudang_id'=>$data->gudang_asal_id,
            'debet'=>null,
            'kredit'=>null,
        ]);

        // make persediaan transaksi masuk
        $persediaanTransaksiMasuk = $jurnalMutasi->persediaan_transaksi()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>(new PersediaanTransaksiRepo())->kode(),
            'jenis'=>'keluar', // masuk atau keluar
            'kondisi'=>$kondisiMasuk, // baik atau rusak
            'gudang_id'=>$data->gudang_tujuan_id,
            'debet'=>null,
            'kredit'=>null,
        ]);

        // transaksi detail
        foreach ($data->data_detail as $item) {
            // store $jurnal mutasi
            // get data persediaan (fifo)
            $stockPersediaan = (new PersediaanRepository())->getProdukForMutasi($item['produk_id'], $data->gudang_id, $item['jumlah']);
            foreach ($stockPersediaan as $row) {
                $persediaanTransaksiKeluar->persediaan_transaksi_detail()->create([
                    'produk_id'=>$row->produk_id,
                    'harga'=>$row->harga,
                    'jumlah'=>$row->jumlah,
                    'sub_total'=>(int)$row->harga * (int)$row->jumlah,
                ]);
                // update persediaan keluar
                (new PersediaanRepository())->updateObject($persediaanTransaksiKeluar, $row, 'stock_keluar');
                $persediaanTransaksiMasuk->persediaan_transaksi_detail()->create([
                    'produk_id'=>$row->produk_id,
                    'harga'=>$row->harga,
                    'jumlah'=>$row->jumlah,
                    'sub_total'=>(int)$row->harga * (int)$row->jumlah,
                ]);
                (new PersediaanRepository())->updateObject($persediaanTransaksiMasuk, $row, 'stock_masuk');
                // update persediaan masuk
            }
        }
        $jurnalTransaksi = new JurnalTransaksiRepository();
        // debet persediaan rusak
        // konfigurasi akun untuk mutasi
        // $jurnalTransaksi->storeDebet();
        // kredit persediaan baik
        // $jurnalTransaksi->storeKredit();
        return $jurnalMutasi;
    }
}
