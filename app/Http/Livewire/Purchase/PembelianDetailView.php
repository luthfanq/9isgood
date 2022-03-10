<?php

namespace App\Http\Livewire\Purchase;

use App\Models\Purchase\Pembelian;
use Livewire\Component;

class PembelianDetailView extends Component
{
    protected $listeners = [
        'show'
    ];

    public $pembelian_data, $pembelian_detail_data;

    public function render()
    {
        return view('livewire.purchase.pembelian-detail');
    }

    public function show(Pembelian $pembelian)
    {
        $this->pembelian_data = $pembelian;
        $this->pembelian_detail_data = $pembelian->pembelianDetail;
    }
}
