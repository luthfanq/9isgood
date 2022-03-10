<?php

namespace App\Http\Livewire\Penjualan;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Penjualan\Penjualan;
use Livewire\Component;

class PenjualanIndex extends Component
{
    use ResetFormTraits;

    public function render()
    {
        return view('livewire.penjualan.penjualan-index');
    }
}
