<?php

namespace App\Http\Livewire\Pembelian;

use App\Models\Master\Gudang;
use App\Models\Purchase\Pembelian;
use Livewire\Component;

class PembelianLuarIndex extends Component
{
    public function render()
    {
        return view('livewire.pembelian.pembelian-luar-index');
    }

}
