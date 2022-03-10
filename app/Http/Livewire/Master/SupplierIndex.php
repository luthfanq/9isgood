<?php

namespace App\Http\Livewire\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\Supplier;
use App\Models\Master\SupplierJenis;
use Livewire\Component;

class SupplierIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit'=>'edit',
        'resetForm'=>'resetForm',
        'destroy'=>'destroy',
        'confirmDestroy'=>'confirmDestroy'
    ];

    public $supplier_id, $jenis_supplier, $nama, $alamat, $telepon, $npwp, $email, $keterangan;

    public array $resetForm = [
        'supplier_id', 'jenis_supplier', 'nama', 'alamat', 'telepon', 'npwp', 'email', 'keterangan'
    ];

    public function render()
    {
        return view('livewire.master.supplier-index', [
            'supplier_jenis_data'=>SupplierJenis::all()
        ]);
    }

    public function edit(Supplier $supplier)
    {
        $this->supplier_id = $supplier->id;
        $this->jenis_supplier = $supplier->supplier_jenis_id;
        $this->nama = $supplier->nama;
        $this->alamat = $supplier->alamat;
        $this->telepon = $supplier->telepon;
        $this->npwp = $supplier->npwp;
        $this->email = $supplier->email;
        $this->keterangan = $supplier->keterangan;
        $this->emit('showModal');
    }

    public function store()
    {
        $this->validate([
            'nama'=>'required|min:3'
        ]);
        Supplier::updateOrCreate(
            [
                'id'=>$this->idSupplier,
            ],
            [
                'supplier_jenis_id'=>$this->jenis_supplier,
                'nama'=>$this->nama,
                'alamat'=>$this->alamat,
                'telepon'=>$this->telepon,
                'npwp'=>$this->npwp,
                'email'=>$this->email,
                'keterangan'=>$this->keterangan,
            ]);
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function destroy($id)
    {
        $this->supplier_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        Supplier::destroy($this->supplier_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatables');
    }
}
