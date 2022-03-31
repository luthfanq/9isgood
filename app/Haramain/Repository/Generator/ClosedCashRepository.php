<?php namespace App\Haramain\Repository\Generator;

use App\Haramain\Repository\Stock\StockOpnameRepository;
use App\Models\ClosedCash;
use App\Models\Keuangan\HargaHppALL;
use App\Models\Keuangan\PersediaanOpname;
use App\Models\Stock\StockAkhir;
use App\Models\Stock\StockOpname;

class ClosedCashRepository
{
    public $diskon_hpp;

    public function __construct()
    {
        $harga_hpp = HargaHppALL::query()->latest()->first();
        $this->diskon_hpp = $harga_hpp->persen;
    }

    public function generateStockOpname()
    {
        // get last session
        $lastSession = ClosedCash::query()
            ->where('closed', session('ClosedCash'))
            ->first();
        $lastSessionValue = $lastSession->active;

        // get stock all stock akhir
        $stock_akhir_data = StockAkhir::query()
            ->where('active_cash', $lastSession)
            ->get();

        // pindah stock akhir
        foreach ($stock_akhir_data as $item) {

            // simpan stock opname baru
            $this->storeStockOpname($item, $item->stock_akhir_detail()->with(['produk'])->get());

            // simpan stock_inventory

            // simpan persediaan
        }
    }

    public function storeStockOpname($data, $data_detail)
    {
        //
    }
}
