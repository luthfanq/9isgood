<?php namespace App\Haramain\Repository\Penjualan;

use App\Haramain\Repository\Stock\StockInventoryRepo;
use App\Models\Penjualan\Penjualan;

class PenjualanRepo
{
    protected Penjualan $penjualan;
    protected $closedCash;
    protected $user;
    protected $kondisi, $jenis, $field;

    protected $stockInventoryRepo;

    public function __construct()
    {
        $this->closedCash = session('ClosedCash');
        $this->user = \Auth::id();
        $this->kondisi = 'baik';
        $this->jenis = 'keluar';
        $this->field = 'stock_keluar';

        // initiate Stock Inventory Repo
        $this->stockInventoryRepo = new StockInventoryRepo();
    }

    public function kode()
    {
        return null;
    }

    public function store($data)
    {
        // simpan penjualan
        $penjualan = Penjualan::query()->create([
            'kode'=>$this->kode(),
            'active_cash'=>$this->closedCash,
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>$this->user,
            'tgl_nota'=>$data->tgl_nota,
            'tgl_tempo'=>($data->jenis_bayar == 'Tempo') ? $data->tgl_tempo : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
            'print'=>null,
        ]);

        // simpan stock keluar
        $stockKeluar = $penjualan->stockKeluarMorph()->create([
            'kode',
            'active_cash'=>$this->closedCash,
            'kondisi'=>$this->kondisi,
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>$data->tgl_nota,
            'user_id'=>$this->user,
            'keterangan'=>$data->keterangan,
        ]);

        // hitung barang saja yang keluar
        $penjualanBersih = $data->total_bayar - (int) $data->ppn - (int) $data->biaya_lain;

        // simpan persediaan transaksi
        $persediaanTransaksiKeluar = $penjualan->persediaan_transaksi()->create([
            'active_cash'=>$this->closedCash,
            'kode',
            'jenis'=>$this->jenis, // masuk atau keluar
            'debet'=>null,
            'kredit'=>$penjualanBersih,
        ]);

        /**
         * Simpan data detail
         * untuk penjualan detail
         * untuk stock keluar detail
         * untuk stock inventory
         */
        foreach ($data->detail as $item){
            // penjualan detail
            $penjualan->penjualanDetail()->create([
                'produk_id'=>$item['produk_id'],
                'harga'=>$item['harga'],
                'jumlah'=>$item['jumlah'],
                'diskon'=>$item['diskon'],
                'sub_total'=>$item['sub_total'],
            ]);

            // stock keluar detail
            $stockKeluar->stockKeluarDetail()->create([
                'produk_id'=>$item['produk_id'],
                'jumlah'=>$item['jumlah'],
            ]);

            // update stock inventory
            $this->stockInventoryRepo->incrementArrayData($item, $data->gudang_id, $this->kondisi, $this->field);
        }
    }
}
