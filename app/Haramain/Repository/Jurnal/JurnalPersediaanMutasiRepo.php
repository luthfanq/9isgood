<?php namespace App\Haramain\Repository\Jurnal;

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

        // make persediaan transaksi
        $persediaanTransaksi = $jurnalMutasi->persediaan_transaksi()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>(new PersediaanTransaksiRepo())->kode(),
            'jenis'=>'keluar', // masuk atau keluar
            'kondisi'=>$kondisiKeluar, // baik atau rusak
            'gudang_id'=>$data->gudang_asal_id,
            'debet'=>null,
            'kredit'=>null,
        ]);
    }
}
