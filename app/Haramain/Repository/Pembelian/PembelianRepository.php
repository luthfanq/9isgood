<?php namespace App\Haramain\Repository\Pembelian;

use App\Haramain\Repository\JurnalTransaksi\JurnalPembelianTrait;
use App\Haramain\Repository\Persediaan\PersediaanJenisMasukRepo;
use App\Haramain\Repository\PersediaanPerpetualRepo;
use App\Haramain\Repository\StockInventoryRepository;
use App\Models\Keuangan\HutangPembelian;
use App\Haramain\Repository\StockMasuk\{StockMasukRepoTrait};
use App\Haramain\Repository\TransaksiRepositoryInterface;
use App\Models\Purchase\Pembelian;

class PembelianRepository implements TransaksiRepositoryInterface
{
    use StockMasukRepoTrait, JurnalPembelianTrait;

    public static function kode(): ?string
    {
        // query
        $query = Pembelian::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()) {
            return '0001/PB/' . date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num) . "/PB/" . date('Y');
    }

    /**
     * membuat pembelian baru
     * include di dalamnya :
     * store pada table pembelian dan pembelian_detail
     * store pada stock_masuk dan update stock_inventory
     * store pada hutang_pembelian dan update saldo_hutang_pembelian
     * store pada persediaan_transaksi dan persediaan_transaksi_detail
     * store pada jurnal_transaksi dengan :
     * persediaan buku baik (diisi pada konfigurasi_jurnal) untuk debet
     * biaya pembelian (jika ada) (diisi pada konfigurasi_jurnal) untuk debet
     * jika buku internal maka hutang
     * @param object $data
     * @param array $detail
     * @return string|null
     */
    public static function create(object $data, array $detail): ?string
    {
        // simpan pembelian
        $pembelian = Pembelian::query()->create([
            'kode'=>self::kode(),
            'active_cash'=>session('ClosedCash'),
            'jenis'=>$data->jenis,
            'nomor_nota'=>$data->nomor_nota,
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $pembelian_bersih = $data->total_bayar - (int)$data->biaya_lain - (int)$data->ppn;

        // id for return
        $pembelian_id = $pembelian->id;

        // simpan pembelian detail
        foreach ($detail as $row){
            $pembelian->pembelianDetail()->create([
                'produk_id' => $row['produk_id'],
                'harga' => $row['harga'],
                'jumlah' => $row['jumlah'],
                'diskon' => $row['diskon'],
                'sub_total' => $row['sub_total'],
            ]);
        }

        // simpan stock masuk dan update stock inventory
        $stockMasuk = self::storeStockMasuk($pembelian->stockMasukMorph(), $data, $detail, 'baik');

        // simpan atau update hutang pembelian
        HutangPembelianRepo::store($data->supplier_id, $pembelian_id, $data->total_bayar);

        // create persediaan jenis_masuk transaksi
        // update persediaan_perpetual
        PersediaanJenisMasukRepo::store($pembelian->persediaan_transaksi(), $pembelian_bersih, $data->gudang_id, $detail);

        // add jurnal_transaksi
        self::storeJurnalPembelian($pembelian->jurnal_transaksi(), $pembelian_bersih, $data);

        return $pembelian_id;
    }

    /**
     * melakukan update pada pembelian
     * rollback terlebih dahulu :
     * rollback stock_inventory
     * rollback saldo_hutang_pembelian
     * delete stock_masuk_detail
     * delete persediaan_transaksi_detail
     * delete jurnal_transaksi
     * @param object $data
     * @param array $detail
     * @return string|null
     */
    public static function update(object $data, array $detail): ?string
    {
        /************
         * Inititate
         ************/
        $field = 'stock_masuk';
        $kondisi = 'baik';
        $pembelian_bersih = $data->total_bayar - (int)$data->biaya_lain - (int)$data->ppn;

        $pembelian = Pembelian::query()->find($data->pembelian_id);
        $pembelian_bersih_old = $pembelian->total_bayar - (int)$pembelian->biaya_lain - (int)$pembelian->ppn;

        $stock_masuk = $pembelian->stockMasukMorph()->first();

        $persediaan_transaksi = $pembelian->persediaan_transaksi()->first();

        $jurnal_transaksi = $pembelian->jurnal_transaksi();

        /*******************
         * ROLLBACK is Coming
         ******************/
        foreach ($pembelian->pembelianDetail as $row)
        {
             //dd(PersediaanPerpetualRepo::rollback($row, 'masuk', $pembelian->gudang_id, $kondisi));
            // rollback stock inventory
            StockInventoryRepository::rollback($row, 'baik', $pembelian->gudang_id, $field);
            // rollback persediaan_perpetual
            PersediaanPerpetualRepo::rollback($row, 'masuk', $pembelian->gudang_id, $kondisi);
        }

        // rollback saldo_hutang_penjualan
        HutangPembelianRepo::rollback($pembelian->supplier_id, $pembelian->total_bayar);

        /***********
         * delete detail
         **********/
        $stock_masuk->stockMasukDetail()->delete();

        $persediaan_transaksi->persediaan_transaksi_detail()->delete();

        $jurnal_transaksi->delete();

        $pembelian->pembelianDetail()->delete();

        /********************
         * Update Data Master
         *******************/
        $pembelian->update([
            'nomor_nota'=>$data->nomor_nota,
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        self::updateStockMasuk($stock_masuk, $data, $kondisi);

        $persediaan_transaksi->update([
            'debet'=>$pembelian_bersih,
        ]);

        $hutangPembelian = $pembelian->hutang_pembelian()->first();
        $hutangPembelian->update([
            'total_bayar'=> $data->total_bayar
        ]);

        HutangPembelian::query()
            ->where('customer_id', $data->customer_id)
            ->increment('saldo', $data->total_bayar);

        // add jurnal_transaksi
        self::storeJurnalPembelian($pembelian->jurnal_transaksi(), $pembelian_bersih, $data);

        /*************************
         * Update Data Detail
         ************************/
        foreach ($detail as $row){
            $pembelian->pembelianDetail()->create([
                'produk_id' => $row['produk_id'],
                'harga' => $row['harga'],
                'jumlah' => $row['jumlah'],
                'diskon' => $row['diskon'],
                'sub_total' => $row['sub_total'],
            ]);
            self::storeStockMasukDetail($stock_masuk, $row, $data->gudang_id, $kondisi, $field);
            PersediaanJenisMasukRepo::storeDetail($persediaan_transaksi, $row, $data->gudang_id, $kondisi);
        }
        return $pembelian->id;
    }

    public static function storeInternal($data)
    {
        $kondisi = 'baik';
        $field = 'stock_masuk';
        $pembelian = Pembelian::query()->create([
            'kode'=>self::kode(),
            'nomor_nota'=>$data->surat_jalan,
            'jenis'=>$data->jenis,
            'active_cash'=>session('ClosedCash'),
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>$data->tgl_masuk,
            'tgl_tempo'=>null,
            'jenis_bayar'=>'cash',
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>null,
            'biaya_lain'=>null,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $pembelian_detail = $pembelian->pembelianDetail();

        $pembelian_bersih = $data->total_bayar - (int)$data->biaya_lain - (int)$data->ppn;

        $stock_masuk = $pembelian->stockMasukMorph();

        $persediaan_transaksi = $pembelian->persediaan_transaksi();

        foreach ($data->detail as $row){
            $pembelian_detail->create([
                'produk_id' => $row['produk_id'],
                'harga' => $row['produk_harga_hpp'],
                'jumlah' => $row['jumlah'],
                'diskon' => 0,
                'sub_total' => $row['sub_total'],
            ]);
            self::storeStockMasukDetail($stock_masuk, $row, $data->gudang_id, $kondisi, $field);
            PersediaanJenisMasukRepo::storeDetail($persediaan_transaksi, $row, $data->gudang_id, $kondisi);
        }

        // add jurnal_transaksi
        self::storeJurnalPembelian($pembelian->jurnal_transaksi(), $pembelian_bersih, $data);
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
