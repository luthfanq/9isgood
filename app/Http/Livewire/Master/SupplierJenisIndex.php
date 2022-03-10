<?php

namespace App\Http\Livewire\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\SupplierJenis;
use Livewire\Component;

class SupplierJenisIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit'=>'edit',
        'resetForm'=>'resetForm',
        'destroy'=>'destroy',
        'confirmDestroy'=>'confirmDestroy'
    ];

    public $jenis_id, $jenis, $keterangan;

    public $resetForm= [
        'jenis_id', 'jenis', 'keterangan'
    ];

    public function render()
    {
        return view('livewire.master.supplier-jenis-index');
    }

    public function edit(SupplierJenis $supplierJenis)
    {
        $this->jenis_id = $supplierJenis->id;
        $this->jenis = $supplierJenis->jenis;
        $this->keterangan = $supplierJenis->keterangan;
        $this->emit('showModal');
    }

    public function store()
    {
        $this->validate([
            'jenis'=>'required'
        ]);

        SupplierJenis::updateOrCreate(
            [
                'id'=>$this->idJenis,
            ],
            [
                'jenis'=>$this->jenis,
                'keterangan'=>$this->keterangan,
            ]);
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function destroy($id)
    {
        $this->jenis_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        SupplierJenis::destroy($this->jenis_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatables');
    }
}
