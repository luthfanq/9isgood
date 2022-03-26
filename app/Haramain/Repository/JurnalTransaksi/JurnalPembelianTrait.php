<?php namespace App\Haramain\Repository\JurnalTransaksi;

trait JurnalPembelianTrait
{
    public static function storeJurnalPembelian(object $jurnalTransaksi, $pembelian_bersih, $data)
    {
        $jurnal_transaksi = $jurnalTransaksi;

        // jurnal transaksi debet
        $jurnal_transaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->akun_persediaan, // konfig persediaan
            'nominal_debet'=>$pembelian_bersih,
        ]);

        if ($data->biaya_lain){
            $jurnal_transaksi->create([
                'active_cash'=>session('ClosedCash'),
                'akun_id'=>$data->akun_biaya_lain, // konfig biaya_lain pembelian
                'nominal_debet'=>$data->biaya_lain,
            ]);
        }

        if ($data->ppn){
            $jurnal_transaksi->create([
                'active_cash'=>session('ClosedCash'),
                'akun_id'=>$data->akun_ppn, // konfig biaya_ppn pembelian
                'nominal_debet'=>$data->ppn,
            ]);
        }

        // jurnal transaksi kredit
        $jurnal_transaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->akun_hutang_dagang, // konfig hutang dagang
            'nominal_kredit'=>$data->ppn,
        ]);
    }
}
