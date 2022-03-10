<?php

namespace App\Http\Livewire\Stock;

use Livewire\Component;

class StockMasukIndex extends Component
{
    public $kondisi;

    public function mount($kondisi = 'baik')
    {
        $this->kondisi = $kondisi;
    }

    public function render()
    {
        return view('livewire.stock.stock-masuk-index');
    }
}
