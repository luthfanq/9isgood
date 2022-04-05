<?php

namespace App\Http\Livewire\Stock;

use App\Haramain\Repository\StockAkhirRepository;
use App\Models\ClosedCash;
use Livewire\Component;

class StockAkhirIndex extends Component
{
    protected $listeners = [
        'destroy',
        'confirmDestroy'
    ];

    public $stock_akhir_id;

    public $lastSession, $lastSessionCondition = false;

    public function render()
    {
        return view('livewire.stock.stock-akhir-index');
    }

    public function setLastSession()
    {
        if ($this->lastSessionCondition){
            $this->lastSession = session('ClosedCash');
            $this->lastSessionCondition = false;
        } else {
            $lastSession = ClosedCash::query()
                ->where('closed', session('ClosedCash'))
                ->first();
            $this->lastSession = $lastSession->active;
            $this->lastSessionCondition = true;
        }
        $this->emit('setLastSession', $this->lastSession);
        $this->emit('refreshDatatable');
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
