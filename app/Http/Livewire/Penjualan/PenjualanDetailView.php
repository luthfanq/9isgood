<?php

namespace App\Http\Livewire\Penjualan;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Sales\Penjualan;
use Livewire\Component;

class PenjualanDetailView extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'showPenjualanDetail'=>'show'
    ];

    public $penjualan_data, $penjualan_detail_data;

    public function render()
    {
        return view('livewire.penjualan.penjualan-detail-view');
    }

    public function show(Penjualan $penjualan)
    {
        $this->penjualan_data = $penjualan;
        $this->penjualan_detail_data = $penjualan->penjualanDetail;
    }
}
