<?php

namespace App\Http\Livewire\Keuangan;

use App\Haramain\Repository\Generator\GeneratePersediaanAwalTempRepo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PersediaanTempIndex extends Component
{
    public function render()
    {
        return view('livewire.keuangan.persediaan-temp-index');
    }

    public function generate()
    {
        \DB::beginTransaction();
        try{
            (new GeneratePersediaanAwalTempRepo())->generate();
            \DB::commit();
        }catch(ModelNotFoundException $e){
            \DB::rollBack();
        }
        $this->emit('refreshDatatable');
    }
}
