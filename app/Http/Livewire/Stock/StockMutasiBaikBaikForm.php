<?php

namespace App\Http\Livewire\Stock;

use App\Models\Stock\StockMutasi;
use Livewire\Component;

class StockMutasiBaikBaikForm extends StockTransaksi
{
    public function render()
    {
        return view('livewire.stock.stock-mutasi-baik-baik-form');
    }
}
