<?php

namespace App\Http\Livewire\Stock;

use App\Models\Stock\StockMutasi;
use Livewire\Component;

class StockMutasiRusakRusakForm extends StockTransaksi
{
    public function render()
    {
        return view('livewire.stock.stock-mutasi-rusak-rusak-form');
    }
}
