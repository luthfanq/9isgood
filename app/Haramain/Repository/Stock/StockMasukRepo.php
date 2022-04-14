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
        // query
        $query = StockMasuk::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'SM' : 'SMR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kodeKondisi}/".date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
    }

    public function store(object $stockMasuk, $data)
    {
        $tglMasuk = $data->tgl_masuk ?? $data->tgl_nota;
        // store stock masuk
        $stockMasuk = $stockMasuk->create([
            'kode'=>$this->kode($data->kondisi),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id,
            'supplier_id'=>$data->supplier_id,
            'tgl_masuk'=>tanggalan_database_format($tglMasuk, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'nomor_po'=>null,
            'nomor_surat_jalan'=>$data->nomor_surat_jalan,
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

        return $stockMasuk;
    }

    public function storeKeuangan(object $stockMasuk, $data)
    {
        //
    }
}
