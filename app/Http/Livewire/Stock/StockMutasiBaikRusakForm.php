<?php

namespace App\Http\Livewire\Stock;

use App\Models\Stock\StockMutasi;
use Livewire\Component;

class StockMutasiBaikRusakForm extends StockTransaksi
{
    public function render()
    {
        return view('livewire.stock.stock-mutasi-baik-rusak-form');
    }
}
