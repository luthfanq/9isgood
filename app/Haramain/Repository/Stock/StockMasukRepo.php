<?php namespace App\Haramain\Repository\Stock;

use App\Models\Stock\StockMasuk;

class StockMasukRepo
{
    protected $stockInventory;

    public function __construct()
    {
        $this->stockInventory = new StockInventoryRepo();
    }

    public function kode($kondisi)
    {
        return null;
    }

    public function store($data)
    {
        // store stock masuk
        $stockMasuk = StockMasuk::query()->create([
            'kode'=>$this->kode($data->kondisi),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id,
            'supplier_id'=>$data->supplier_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_masuk, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'nomor_po'=>null,
            'nomor_surat_jalan'=>$data->surat_jalan,
            'keterangan'=>$data->keterangan,
        ]);
        // store detail
        foreach ($data->data_detail as $item)
        {
            $stockMasuk->stockMasukDetail()->create([
                'produk_id'=>$item['produk_id'],
                'jumlah'=>$item['jumlah'],
            ]);
            // stock inventory
            $this->stockInventory->incrementArrayData($item, $data->gudang_id, $data->kondisi, 'stock_masuk');
        }
    }

    public function storeKeuangan(object $stockMasuk, $data)
    {
        //
    }
}
