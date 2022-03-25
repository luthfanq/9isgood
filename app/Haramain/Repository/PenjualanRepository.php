<?php

namespace App\Haramain\Repository;

use App\Haramain\Repository\RepoTraits\StockKeluarRepoTraits;
use App\Models\KonfigurasiJurnal;
use App\Models\Penjualan\Penjualan;

class PenjualanRepository implements TransaksiRepositoryInterface
{
    use StockKeluarRepoTraits;

    public static function kode(): ?string
    {
        $query = Penjualan::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()){
            return '0001/PJ/'.date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/PJ/".date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        // create penjualan
        // return object penjualan
        $penjualan = Penjualan::query()->create([
            'kode'=>self::kode(),
            'active_cash'=>session('ClosedCash'),
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_bayar,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        /*********************************
         * Kepentingan Transaksi keuangan
         **********************************/

        // create jurnal Penjualan
        $jurnal_penjualan = $penjualan->jurnal_penjualan()->create([
            'kode'=>JurnalPenjualanRepository::kode(),
            'active_cash'=>session('ClosedCash'),
        ]);

        // initiate transaksi akun
        $nominal_penjualan = $data->total_bayar - (int)$data->biaya_lain - (int)$data->ppn;

        $queryKonfigJurnal = KonfigurasiJurnal::query();
        $akun_piutang = $queryKonfigJurnal->find('piutang_penjualan')->akun_id;
        $akun_penjualan = $queryKonfigJurnal->find('penjualan')->akun_id;
        $akun_biaya_lain = $queryKonfigJurnal->find('biaya_lain')->akun_id;
        $akun_ppn = $queryKonfigJurnal->find('ppn')->akun_id;

        $jurnal_penjualan->jurnalable_transaksi()->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$akun_piutang,
            'nominal_debet'=>$nominal_penjualan,
        ]);

        $jurnal_penjualan->jurnalable_transaksi()->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$akun_penjualan,
            'nominal_kredit'=>$nominal_penjualan,
        ]);

        // create jurnal transaksi debet
        if ($data->biaya_lain || $data->ppn){

            if ($data->biaya_lain){
                $jurnal_penjualan->jurnalable_transaksi()->create([
                    'active_cash'=>session('ClosedCash'),
                    'akun_id'=>$akun_biaya_lain,
                    'nominal_kredit'=>$akun_biaya_lain,
                ]);
            }

            if ($data->ppn){
                $jurnal_penjualan->jurnalable_transaksi()->create([
                    'active_cash'=>session('ClosedCash'),
                    'akun_id'=>$akun_ppn,
                    'nominal_kredit'=>$akun_biaya_lain,
                ]);
            }
        }

        /***************************
         * Kepentingan Stock Keluar
         ***************************/

        // create stock_masuk jenis baik
        $stock_keluar= self::storeStockKeluar($penjualan->stockKeluarMorph(), $data);

        // create hpp

        // detail proses
        return self::detailProses($detail, $penjualan, $stock_keluar, 'baik',$data);
    }

    public static function update(object $data, array $detail): ?string
    {
        $penjualan = Penjualan::query()
            ->with(['stockKeluar.stockKeluarDetail'])
            ->find($data->penjualan_id);

        // dd($penjualan->stockKeluarMorph->stockKeluarDetail());

        // rollback inventory
        foreach ($penjualan->penjualanDetail as $row)
        {
            StockInventoryRepository::rollback($row, 'baik', $penjualan->gudang_id, 'stock_keluar');
        }

        // delete penjualan detail
        $penjualan->penjualanDetail()->delete();

        // update Penjualan
        $penjualan->update([
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->customer_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_bayar,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stock_keluar = $penjualan->stockKeluarMorph()->first();

        // delete stock keluar detail
        $penjualan->stockKeluarMorph->stockKeluarDetail()->delete();

        // update stock keluar
        $stock_keluar->update([
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // detail proses
        return self::detailProses($detail, $penjualan, $stock_keluar, 'baik', $data);
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
        return null;
    }

    /**
     * @param array $detail
     * @param Penjualan $penjualan
     * @param $stock_keluar
     * @param object $data
     * @return string|null
     */
    protected static function detailProses(array $detail, Penjualan $penjualan, $stock_keluar, $kondisi,object $data): ?string
    {
        foreach ($detail as $item) {
            $penjualan->penjualanDetail()->create([
                'produk_id' => $item['produk_id'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'diskon' => $item['diskon'],
                'sub_total' => $item['sub_total'],
            ]);

            $stock_keluar->stockKeluarDetail()->create([
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
            ]);

            StockInventoryRepository::create(
                (object)[
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah']
                ],
                $kondisi,
                $data->gudang_id,
                'stock_keluar'
            );
        }

        return $penjualan->id;
    }
}
