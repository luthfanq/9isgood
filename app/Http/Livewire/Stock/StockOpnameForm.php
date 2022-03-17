<?php

namespace App\Http\Livewire\Stock;

use App\Models\Stock\StockOpname;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StockOpnameForm extends StockTransaksi
{
    public $jenis;
    public function render()
    {
        return view('livewire.stock.stock-opname-form');
    }
}
