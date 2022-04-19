<?php namespace App\Haramain\Repository\Penjualan;

use App\Haramain\Repository\Neraca\NeracaSaldoRepository;
use App\Models\Keuangan\PiutangPenjualanLama;
use App\Models\Penjualan\Penjualan;

class PenjualanLamaRepository
{
    public function store($data)
    {
        // simpan dan return object PiutangPenjualanLama
        $piutangLama = PiutangPenjualanLama::query()
            ->create([
                'tahun_nota'=>$data->tahun_nota,
                'customer_id'=>$data->customer_id,
                'user_Id'=>\Auth::id(),
                'total_piutang'=>$data->total_piutang,
                'keterangan'=>$data->keterangan,
            ]);

        // each data detail
        $total_bayar = 0;
        foreach ($data->data_detail as $item) {
            $total_bayar += $item['total_bayar'];
            // simpan penjualan
            $penjualan = Penjualan::query()
                ->create([
                    'kode'=>$item['nomor_nota'],
                    'active_cash'=>'old',
                    'customer_id'=>$data->customer_id,
                    'gudang_id'=>1,
                    'user_id'=>\Auth::id(),
                    'tgl_nota'=>tanggalan_database_format($item['tgl_nota'], 'd-M-Y'),
                    'jenis_bayar'=>'tempo',
                    'status_bayar'=>'belum',
                    'total_barang'=>0,
                    'total_bayar'=>$item['total_bayar'],
                ]);
            $piutangLamaDetail = $piutangLama->piutangPenjualanLamaDetail()
                ->create([
                    'penjualan_id'=>$penjualan->id,
                    'total_bayar'=>$item['total_bayar'],
                ]);
        }

        // simpan jurnal transaksi
        $jurnalTransaksi = $piutangLama->jurnalTransaksi();
        // jurnal transaksi debet
        $jurnalTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->piutang_dagang,
            'nominal_debet'=>$total_bayar,
            'nominal_kredit'=>null,
        ]);
        // jurnal transaksi kredit
        $jurnalTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->modal_awal,
            'nominal_debet'=>null,
            'nominal_kredit'=>$total_bayar,
        ]);
        // simpan neraca saldo awal debet piutang dagang
        (new NeracaSaldoRepository())->updateOneRow($data->piutang_dagang, $total_bayar, null);
        // simpan neraca saldo awal kredit modal awal
        (new NeracaSaldoRepository())->updateOneRow($data->modal_awal, null, $total_bayar);

        return $piutangLama->id;
    }

    public function update()
    {
        // inititate
        // rollback
    }
}
