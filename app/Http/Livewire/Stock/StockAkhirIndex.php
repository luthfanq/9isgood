<?php

namespace App\Http\Livewire\Stock;

use App\Haramain\Repository\StockAkhirRepository;
use Livewire\Component;

class StockAkhirIndex extends Component
{
    protected $listeners = [
        'destroy',
        'confirmDestroy'
    ];

    public $stock_akhir_id;

    public function render()
    {
        return view('livewire.stock.stock-akhir-index');
    }

    public function destroy($id)
    {
        $this->stock_akhir_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        StockAkhirRepository::delete($this->stock_akhir_id);
        $this->reset(['stock_akhir_id']);
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }
}
