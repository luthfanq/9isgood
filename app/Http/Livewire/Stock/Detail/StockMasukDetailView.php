<?php

namespace App\Http\Livewire\Stock\Detail;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Stock\StockMasuk;
use Livewire\Component;

class StockMasukDetailView extends Component
{
    protected $listeners = [
        'showStockDetail'=>'show'
    ];

    public $stock_data, $stock_detail_data;

    public function render()
    {
        return view('livewire.stock.detail.stock-masuk-detail-view');
    }

    public function show(StockMasuk $stock_masuk)
    {
        $this->stock_data = $stock_masuk;
        $this->stock_detail_data = $stock_masuk->stockMasukDetail;
    }
}
