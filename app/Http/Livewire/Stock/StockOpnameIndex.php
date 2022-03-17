<?php

namespace App\Http\Livewire\Stock;

use Livewire\Component;

class StockOpnameIndex extends Component
{
    public $jenis;

    public function mount($jenis = 'baik')
    {
        $this->jenis = $jenis;
    }

    public function render()
    {
        return view('livewire.stock.stock-opname-index');
    }
}
