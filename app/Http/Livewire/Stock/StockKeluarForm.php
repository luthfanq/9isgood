<?php

namespace App\Http\Livewire\Stock;

use Livewire\Component;

class StockKeluarForm extends Component
{
    public $kondisi;

    public function mount($kondisi = null)
    {
        $this->kondisi = ($kondisi) ? $kondisi : 'baik';
    }
    
    public function render()
    {
        return view('livewire.stock.stock-keluar-form');
    }
}
