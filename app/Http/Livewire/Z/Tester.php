<?php

namespace App\Http\Livewire\Z;

use App\Models\Keuangan\Persediaan;
use App\Models\Penjualan\Penjualan;
use App\Models\Penjualan\PenjualanRetur;
use App\Models\Purchase\Pembelian;
use App\Models\Purchase\PembelianRetur;
use App\Models\Stock\StockOpname;
use Livewire\Component;

class Tester extends Component
{
    public $stockData, $produk_id;
    public function mount()
    {
        $this->stockData = $this->queryMe();
    }

    public function queryMe()
    {
        return Persediaan::query()
            ->where('produk_id', 1)
            ->where('active_cash', session('ClosedCash'))
            ->where('gudang_id', 1)->get();
    }

    public function render()
    {
        return view('livewire.z.tester');
    }
}
