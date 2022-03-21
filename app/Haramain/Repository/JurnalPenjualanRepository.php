<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\JurnalPenjualan;
use App\Models\Penjualan\Penjualan;

class JurnalPenjualanRepository implements TransaksiRepositoryInterface
{

    public static function kode(): ?string
    {
        $jurnalPenjualan = JurnalPenjualan::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');
        if ($jurnalPenjualan->doesntExist()){
            return '1/JPJ/'.date('Y');
        }
        return $jurnalPenjualan->first()->last_num_char +1 .'/JPJ/'.date('Y');
    }

    /**
     * Simpan Jurnal Penjualan
     * Simpan Jurnal Penjualan Detail
     * Update Status Bayar pada colom Penjualan
     * Simpan Jurnal Kas
     * Simpan Jurnal Transaksi
     * @param object $data
     * @param array $detail
     * @return string|null nilai kembalian untuk kepentingan cetak (printing)
     */
    public static function create(object $data, array $detail): ?string
    {
        // Simpan Jurnal Penjualan
        $jurnalPenjualan = JurnalPenjualan::query()->create([
            'kode'=>self::kode(),
            'active_cash'=>session('ClosedCash'),
            'tgl_jurnal'=>tanggalan_database_format($data->tgl_jurnal, 'd-M-Y'),
            'customer_id'=>$data->customer,
            'total_penjualan'=>$data->total_penjualan,
            'total_biaya_lain'=>$data->total_biaya_lain,
            'total_hutang_ppn'=>$data->total_hutang_ppn,
            'total_bayar'=>$data->total_bayar,
            'total_kas'=>$data->total_kas,
            'total_piutang'=>$data->total_piutang,
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // initiate realtion jurnal_transaksi table
        $jurnalTransaksi = $jurnalPenjualan->jurnal_transaksi();

        /**
         * Jika nilai total_kas ada, maka :
         * buat transaksi akun kas debet pada jurnal_transaksi
         * simpan pada jurnal_kas
         */
        if ($data->total_kas){
            $jurnalTransaksi->create([
                'active_cash'=>session('ClosedCash'),
                'akun_id'=>$data->akun_kas,
                'nominal_debet'=>$data->total_kas,
            ]);

            $jurnalKas = $jurnalPenjualan->jurnal_kas()->create([
                'kode'=>JurnalKasRepository::kode(),
                'type'=>'debet',
                'active_cash'=>session('ClosedCash'),
                'akun_id'=>$data->akun_kas,
                'nominal_debet'=>$data->nominal_kas,
                'nominal_kredit'=>null,
                'nominal_saldo'=>JurnalKasRepository::getNominalSaldo($data->akun_kas) + $data->nominal_kas,
            ]);
        }

        /**
         * Jika nilai total_piutang ada, maka :
         * buat akun piutang debet pada jurnal_transaksi
         * simpan pada jurnal_piutang
         * update atau buat baru saldo piutang dari customer
         */
        if ($data->total_piutang){
            $jurnalTransaksi->create([
                'active_cash'=>session('ClosedCash'),
                'akun_id'=>$data->akun_kas,
                'nominal_debet'=>$data->total_piutang,
            ]);

            $jurnalPiutangPenjualan = $jurnalPenjualan->jurnal_piutang()->create([
                'kode'=>JurnalPiutangPenjualanRepo::kode(),
                'active_cash'=>session('ClosedCash'),
                'customer_id'=>$data->customer_id,
                'akun_id'=>$data->akun_piutang,
                'nominal_debet'=>$data->nominal_piutang,
                'nominal_kredit'=>null,
                'nominal_saldo'=>JurnalPiutangPenjualanRepo::getNominalSaldo($data->customer_id) + $data->nominal_piutang,
            ]);

            SaldoPiutangPenjualanRepository::increment($data->customer_id, $data->tgl_jurnal, $data->nominal_piutang);
        }

        /**
         * simpan data berdasarkan detail data
         */
        self::storeDetail($detail, $jurnalPenjualan, $jurnalTransaksi);

        /**
         * kredit penjualan pada jurnal_transaksi
         */
        $jurnalTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->akun_penjualan,
            'nominal_debet'=>null,
            'nominal_kredit'=>$data->total_penjualan,
        ]);

        return $jurnalPenjualan->id;
    }

    public static function update(object $data, array $detail): ?string
    {
        $jurnalPenjualan = JurnalPenjualan::query()->find($data->penjualan_id);

        $jurnalTransaksi = $jurnalPenjualan->jurnal_transaksi();

        // rollback
        $jurnalTransaksi->delete();
        SaldoPiutangPenjualanRepository::decrement($jurnalPenjualan->customer_id, $jurnalPenjualan->nominal_piutang);
        foreach ($jurnalPenjualan->jurnal_penjualan_detail as $item){
            Penjualan::query()->find($item->penjualan_id)->update([
                'status_bayar'=>'belum'
            ]);
        }
        $jurnalPenjualan->jurnal_penjualan_detail()->delete();

        // update jurnal penjualan
        $jurnalPenjualan->update([
            'tgl_jurnal'=>tanggalan_database_format($data->tgl_jurnal, 'd-M-Y'),
            'customer_id'=>$data->customer,
            'total_penjualan'=>$data->total_penjualan,
            'total_biaya_lain'=>$data->total_biaya_lain,
            'total_hutang_ppn'=>$data->total_hutang_ppn,
            'total_bayar'=>$data->total_bayar,
            'total_kas'=>$data->total_kas,
            'total_piutang'=>$data->total_piutang,
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        if ($data->total_kas){
            $jurnalTransaksi->create([
                'active_cash'=>session('ClosedCash'),
                'akun_id'=>$data->akun_kas,
                'nominal_debet'=>$data->total_kas,
            ]);

            $jurnalKas = $jurnalPenjualan->jurnal_kas()->update([
                'akun_id'=>$data->akun_kas,
                'nominal_debet'=>$data->nominal_kas,
                'nominal_kredit'=>null,
                'nominal_saldo'=>JurnalKasRepository::getNominalSaldo($data->akun_kas) + $data->nominal_kas,
            ]);
        }

        if ($data->total_piutang){
            $jurnalTransaksi->create([
                'active_cash'=>session('ClosedCash'),
                'akun_id'=>$data->akun_kas,
                'nominal_debet'=>$data->total_piutang,
            ]);

            $jurnalPiutangPenjualan = $jurnalPenjualan->jurnal_piutang()->update([
                'customer_id'=>$data->customer_id,
                'akun_id'=>$data->akun_piutang,
                'nominal_debet'=>$data->nominal_piutang,
                'nominal_kredit'=>null,
                'nominal_saldo'=>JurnalPiutangPenjualanRepo::getNominalSaldo($data->customer_id) + $data->nominal_piutang,
            ]);

            SaldoPiutangPenjualanRepository::increment($data->customer_id, $data->nominal_piutang);
        }

        /**
         * simpan data berdasarkan detail data
         */
        self::storeDetail($detail, $jurnalPenjualan, $jurnalTransaksi);

        /**
         * kredit penjualan pada jurnal_transaksi
         */
        $jurnalTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->akun_penjualan,
            'nominal_debet'=>null,
            'nominal_kredit'=>$data->total_penjualan,
        ]);

        return $jurnalPenjualan->id;
    }

    public static function delete(int $id): ?string
    {
        $jurnalPenjualan = JurnalPenjualan::query()->find($id);

        $jurnalTransaksi = $jurnalPenjualan->jurnal_transaksi();

        // rollback
        $jurnalTransaksi->delete();
        SaldoPiutangPenjualanRepository::decrement($jurnalPenjualan->customer_id, $jurnalPenjualan->nominal_piutang);
        foreach ($jurnalPenjualan->jurnal_penjualan_detail as $item){
            Penjualan::query()->find($item->penjualan_id)->update([
                'status_bayar'=>'belum'
            ]);
        }
        $jurnalPenjualan->jurnal_penjualan_detail()->delete();

        $jurnalKas = $jurnalPenjualan->jurnal_kas()->delete();
        $jurnalPiutang = $jurnalPenjualan->jurnal_piutang()->delete();

        $jurnalPenjualan->delete();

        return $jurnalPenjualan->id;
    }

    /**
     * simpan dari masing-masing detail pada detail dari form jurnal penjualan
     * @param array $detail
     * @param JurnalPenjualan $jurnalPenjualan
     * @param $jurnalTransaksi
     */
    protected static function storeDetail(array $detail, JurnalPenjualan $jurnalPenjualan, $jurnalTransaksi): void
    {
        foreach ($detail as $item) {

            // set penjualan sudah bayar
            Penjualan::query()->find($item->penjualan_id)->update([
                'status_bayar'=>'lunas'
            ]);

            // jurnal penjualan detail
            $jurnalPenjualan->jurnal_penjualan_detail()->create([
                'penjualan_id' => $item->penjualan_id,
                'total_penjualan' => $item->total_penjualan,
                'akun_biaya_1' => $item->akun_biaya_1,
                'total_biaya_1' => $item->total_biaya_1,
                'akun_biaya_2' => $item->akun_biaya_2,
                'total_biaya_2' => $item->total_biaya_2,
                'akun_ppn' => $item->akun_ppn,
                'total_ppn' => $item->total_ppn,
            ]);

            if ($item->total_biaya_1) {
                $jurnalTransaksi->create([
                    'active_cash' => session('ClosedCash'),
                    'akun_id' => $item->akun_biaya_1,
                    'nominal_debet' => $item->total_biaya_1,
                    'keterangan' => $item->penjualan_kode
                ]);
            }

            if ($item->total_biaya_2) {
                $jurnalTransaksi->create([
                    'active_cash' => session('ClosedCash'),
                    'akun_id' => $item->akun_biaya_2,
                    'nominal_debet' => $item->total_biaya_2,
                    'keterangan' => $item->penjualan_kode
                ]);
            }

            if ($item->total_ppn) {
                $jurnalTransaksi->create([
                    'active_cash' => session('ClosedCash'),
                    'akun_id' => $item->akun_ppn,
                    'nominal_debet' => $item->total_ppn,
                    'keterangan' => $item->penjualan_kode
                ]);
            }
        }
    }
}
