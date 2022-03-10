<?php

namespace App\Http\Livewire\Penjualan;

use Livewire\Component;

class PenjualanReturIndex extends Component
{
    public $kondisi;

    public function mount($kondisi='baik')
    {
        $this->kondisi = $kondisi;
    }

    public function render()
    {
        return view('livewire.penjualan.penjualan-retur-index');
    }
}
