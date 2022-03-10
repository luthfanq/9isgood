<?php

namespace App\Http\Livewire\Stock;

use Livewire\Component;

class StockMasukForm extends Component
{
    public $jenis;

    public function mount($jenis = null)
    {
        $this->jenis = ($jenis) ? $jenis : 'baik';
    }

    public function render()
    {
        return view('livewire.stock.stock-masuk-form');
    }
}
