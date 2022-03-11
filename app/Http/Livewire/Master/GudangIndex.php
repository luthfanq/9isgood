<?php

namespace App\Http\Livewire\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\Gudang;
use Livewire\Component;

class GudangIndex extends Component
{
    use ResetFormTraits;

    public $gudang_id, $nama, $alamat, $kota, $keterangan;

    protected $listeners = [
        'edit'=>'edit',
        'resetForm'=>'resetForm',
        'destroy'=>'destroy',
        'confirmDestroy'=>'confirmDestroy'
    ];

    public $resetForm = [
        'gudang_id', 'nama', 'alamat', 'kota', 'keterangan'
    ];

    public function render()
    {
        return view('livewire.master.gudang-index');
    }

    public function edit(Gudang $gudang)
    {
        $this->gudang_id = $gudang->id;
        $this->nama = $gudang->nama;
        $this->alamat = $gudang->alamat;
        $this->kota = $gudang->kota;
        $this->keterangan = $gudang->keterangan;
        $this->emit('showModal');
    }

    public function store()
    {
        $this->validate([
            'nama'=>'required|min:3',
        ]);

        Customer::updateOrCreate(
            [
                'id'=>$this->gudang_id,
            ],
            [
                'nama'=>$this->nama,
                'alamat'=>$this->alamat,
                'kota'=>$this->kota,
                'keterangan'=>$this->keterangan
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function destroy($id)
    {
        $this->gudang_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        Gudang::destroy($this->produk_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatables');
    }
}
