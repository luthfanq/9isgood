<?php namespace App\Haramain\Repository\Generator;

use App\Haramain\Repository\Stock\StockInventoryRepo;
use App\Haramain\Repository\Stock\StockOpnameRepository;
use App\Models\ClosedCash;
use App\Models\Keuangan\HargaHppALL;
use App\Models\Keuangan\PersediaanOpname;
use App\Models\Stock\StockAkhir;
use App\Models\Stock\StockOpname;

class ClosedCashRepository
{
    public $diskon_hpp;
    public $stockInventory;

    public function __construct()
    {
        $harga_hpp = HargaHppALL::query()->latest()->first();
        $this->diskon_hpp = $harga_hpp->persen;
        $this->stockInventory = new StockInventoryRepo();
    }

    public function generateStockOpname($newSession)
    {
        // get last session
        $lastSession = ClosedCash::query()
            ->where('closed', $newSession)
            ->first();

        $lastSessionValue = $lastSession->active;

        // get stock all stock akhir
        $stock_akhir_data = StockAkhir::query()
            ->where('active_cash', $lastSessionValue)
            ->oldest('kode')
            ->get();

        // pindah stock akhir
        foreach ($stock_akhir_data as $item) {

            // simpan stock opname baru
            $this->storeStockOpname($item, $item->stock_akhir_detail()->with(['produk'])->get(), $newSession);
        }
    }

    public function storeStockOpname($data, $data_detail, $newSession)
    {
        // buat stock opname baru
        $stockOpname = StockOpname::query()->create([
            'active_cash'=>$newSession,
            'kode'=>StockOpnameRepository::kode($data->jenis),
            'jenis'=>$data->jenis,
            'tgl_input'=>$data->tgl_input,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'pegawai_id'=>$data->pegawai_id,
            'keterangan'=>$data->keterangan,
        ]);

        foreach ($data_detail as $item){
            // store stock opname detail
            $stockOpname->stockOpnameDetail()->create([
                'produk_id'=>$item->produk_id,
                'jumlah'=>$item->jumlah,
            ]);

            // store stock awal
            $this->stockInventory->incremetObjectData($item, $data->gudang_id, $data->jenis, 'stock_opname', $newSession);
        }
    }
}
