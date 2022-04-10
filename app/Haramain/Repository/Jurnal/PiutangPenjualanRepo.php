<?php namespace App\Haramain\Repository\Jurnal;

use App\Haramain\Repository\Saldo\SaldoPiutangPenjualanrepo;
use App\Models\Keuangan\JurnalSetPiutangAwal;
use App\Models\Keuangan\SaldoPiutangPenjualan;

class PiutangPenjualanRepo
{
    protected function kode()
    {
        $query = JurnalSetPiutangAwal::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()){
            return '0001/PP/'.date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/PP/".date('Y');
    }

    public function store($data)
    {
        // initiate
        $biayaLain = 0;
        $ppn = 0;
        $saldoPiutangPenjualan = (new SaldoPiutangPenjualanrepo())->find($data->customer_id); // bisa diganti dengan repository
        // store data jurnal set piutang awal
        $jurnalSetPiutang = JurnalSetPiutangAwal::query()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>$this->kode(),
            'tgl_jurnal'=>tanggalan_database_format($data->tgl_jurnal, 'd-M-Y'),
            'customer_id'=>$data->customer_id,
            'user_id'=>\Auth::id(),
        ]);
        // store piutang penjualan
        foreach ($data->data_detail as $row){
            $jurnalSetPiutang->piutang_penjualan()->create([
                'saldo_piutang_penjualan_id'=>$saldoPiutangPenjualan->customer_id,
                'penjualan_id'=>$data->penjualan_id,
                'status_bayar'=>'belum', // enum ['lunas', 'belum', 'kurang']
                'kurang_bayar'=>$data->total_bayar,
            ]);
            // update saldo piutang penjualan
            $saldoPiutangPenjualan->increment('saldo', $row['penjualan_total_bayar']);
            $biayaLain += $row['penjualan_biaya_lain'];
            $ppn += $row['penjualan_ppn'];
        }
        // store jurnal transaksi
        $jurnalTransaksi = $jurnalSetPiutang->jurnal_transaksi();

        // store debet (piutang)
        // store kredit (pendapatan periode lalu -- prive)
        // update neraca saldo awal
    }
}
