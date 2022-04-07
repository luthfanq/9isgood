<?php

namespace App\Http\Livewire\Config;

use App\Models\Keuangan\HargaHppALL;
use Livewire\Component;

class ConfigHpp extends Component
{
    public $configVar = [];
    public $deskripsi = [];
    public $persen;

    public function mount()
    {
        $this->configVar = HargaHppALL::all();
        foreach ($this->configVar as $item){
            $this->persen[$item->id] = $item->persen;
        }
    }

    public function render()
    {
        return view('livewire.config.config-hpp');
    }

    public function update(int $id)
    {
        $this->validate([
            'persen.*'=>'required'
        ]);
        //dd($this->persen[$id]);
        $hargaHpp = HargaHppALL::query()->find($id);
        $hargaHpp->update([
            'persen'=>$this->persen[$id]
        ]);
    }
}
