<?php

namespace App\Http\Livewire\Stock;

use App\Models\Master\Gudang;
use Livewire\Component;

class InventoryByJenisIndex extends Component
{
    public $jenis, $gudang, $gudang_nama;

    public function mount($jenis, $gudang)
    {
        $this->jenis = $jenis;
        $this->gudang = $gudang;
        $gudang_data = Gudang::query()->find($gudang);
        $this->gudang_nama = $gudang_data->nama;
    }

    public function render()
    {
        return view('livewire.stock.inventory-by-jenis-index');
    }
}
