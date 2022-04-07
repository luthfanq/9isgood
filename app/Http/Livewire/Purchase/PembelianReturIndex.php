<?php

namespace App\Http\Livewire\Purchase;

use Livewire\Component;

class PembelianReturIndex extends Component
{

    public $kondisi;

    public function mount($kondisi='baik')
    {
        $this->kondisi = $kondisi;
    }
    public function render()
    {
        return view('livewire.purchase.pembelian-retur-index');
    }
}
