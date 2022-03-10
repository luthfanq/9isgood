<?php

namespace App\Http\Livewire\Stock;

use Livewire\Component;

class StockKeluarIndex extends Component
{
    public $kondisi, $gudang;

    public function mount($kondisi='baik')
    {
        $this->kondisi = $kondisi;
    }

    public function render()
    {
        return view('livewire.stock.stock-keluar-index');
    }
}
