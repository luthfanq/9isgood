<?php namespace App\Haramain\Repository\Penjualan;

use App\Haramain\Repository\Neraca\NeracaSaldoRepository;
use App\Haramain\Repository\Saldo\SaldoPiutangPenjualanrepo;
use App\Models\Keuangan\NeracaSaldo;
use App\Models\Keuangan\PiutangPenjualan;
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

        // saldo piutang update

        // each data detail
        return $this->storeDetail($data, $piutangLama);
    }

    public function update($data)
    {
        // inititate
        $piutangLama = PiutangPenjualanLama::query()->find($data->piutang_id);
        $saldoPiutangPenjualan = (new SaldoPiutangPenjualanrepo())->find($data->customer_id);

        // rollback
        foreach ($piutangLama->piutangPenjualanLamaDetail as $item) {
            // rollback saldo piutang
            $saldoPiutangPenjualan->decrement('saldo', $item->total_bayar);
            // delete piutang penjualan
            PiutangPenjualan::query()->where('penjualan_id', $item->penjualan_id)->delete();
            // delete penjualan
            $penjualan = Penjualan::query()->firstWhere('id', $item->penjualan_id);
            $penjualan->delete();
        }

        // delete detail
        $piutangLama->piutangPenjualanLamaDetail()->delete();

        // initiate jurnal transaksi
        $jurnalTransaksi = $piutangLama->jurnalTransaksi();

        // rollback neraca saldo
        foreach ($piutangLama->jurnalTransaksi as $item) {
            (new NeracaSaldoRepository())->rollback($item);
        }

        // delete jurnal transaksi
        $jurnalTransaksi->delete();

        // update
        $piutangLama->update([
            'tahun_nota'=>$data->tahun_nota,
            'customer_id'=>$data->customer_id,
            'user_Id'=>\Auth::id(),
            'total_piutang'=>$data->total_piutang,
            'keterangan'=>$data->keterangan,
        ]);

        // insert detail
        // each data detail
        return $this->storeDetail($data, $piutangLama);
    }

    /**
     * @param $data
     * @param \Illuminate\Database\Eloquent\Model|array|null $piutangLama
     * @return mixed
     */
    public function storeDetail($data, \Illuminate\Database\Eloquent\Model|array|null $piutangLama): mixed
    {
        // initiate saldo piutang penjualan
        $saldoPiutangPenjualan = (new SaldoPiutangPenjualanrepo())->find($data->customer_id);

        $total_bayar = 0;
        foreach ($data->data_detail as $item) {
            $total_bayar += $item['total_bayar'];
            // simpan penjualan
            $penjualan = Penjualan::query()
                ->create([
                    'kode' => $item['nomor_nota'],
                    'active_cash' => 'old',
                    'customer_id' => $data->customer_id,
                    'gudang_id' => 1,
                    'user_id' => \Auth::id(),
                    'tgl_nota' => tanggalan_database_format($item['tgl_nota'], 'd-M-Y'),
                    'jenis_bayar' => 'tempo',
                    'status_bayar' => 'set_piutang',
                    'total_barang' => 0,
                    'total_bayar' => $item['total_bayar'],
                ]);
            // create piutang penjualan
            $saldoPiutangPenjualan->piutang_penjualan()->create([
                'penjualan_id'=>$penjualan->id,
                'status_bayar'=>'belum', // enum ['lunas', 'belum', 'kurang']
                'kurang_bayar'=>$item['total_bayar'],
            ]);
            // update saldo piutangs
            $saldoPiutangPenjualan->increment('saldo', $item['total_bayar']);

            // insert piutanglamadetail
            $piutangLamaDetail = $piutangLama->piutangPenjualanLamaDetail()
                ->create([
                    'penjualan_id' => $penjualan->id,
                    'total_bayar' => $item['total_bayar'],
                ]);
        }

        // simpan jurnal transaksi
        $jurnalTransaksi = $piutangLama->jurnalTransaksi();
        // jurnal transaksi debet
        $jurnalTransaksi->create([
            'active_cash' => session('ClosedCash'),
            'akun_id' => $data->piutang_dagang,
            'nominal_debet' => $total_bayar,
            'nominal_kredit' => null,
        ]);
        // jurnal transaksi kredit
        $jurnalTransaksi->create([
            'active_cash' => session('ClosedCash'),
            'akun_id' => $data->modal_awal,
            'nominal_debet' => null,
            'nominal_kredit' => $total_bayar,
        ]);
        // simpan neraca saldo awal debet piutang dagang
        (new NeracaSaldoRepository())->updateOneRow($data->piutang_dagang, $total_bayar, null);
        // simpan neraca saldo awal kredit modal awal
        (new NeracaSaldoRepository())->updateOneRow($data->modal_awal, null, $total_bayar);

        return $piutangLama->id;
    }
}
