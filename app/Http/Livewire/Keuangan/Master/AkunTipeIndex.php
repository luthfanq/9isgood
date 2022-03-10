<?php

namespace App\Http\Livewire\Keuangan\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Keuangan\AkunTipe;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AkunTipeIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit',
        'resetForm',
        'destroy',
        'confirmDestroy'
    ];

    public $akun_tipe_id, $kode, $deskripsi, $keterangan;

    public $resetForm = ['akun_tipe_id', 'kode', 'deskripsi', 'keterangan'];

    public function render()
    {
        return view('livewire.keuangan.master.akun-tipe-index');
    }

    public function store()
    {
        $this->validate([
            'kode'=>['required',
                Rule::unique('akun_tipe', 'kode')->ignore($this->akun_tipe_id)
            ],
            'deskripsi'=>'required|min:3',
        ]);

        AkunTipe::updateOrCreate(
            [
                'id'=>$this->akun_tipe_id,
            ],
            [
                'kode'=>$this->kode,
                'deskripsi'=>$this->deskripsi,
                'keterangan'=>$this->keterangan
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function edit(AkunTipe $akun)
    {
        $this->akun_tipe_id = $akun->id;
        $this->kode = $akun->kode;
        $this->deskripsi = $akun->deskripsi;
        $this->keterangan = $akun->keterangan;
        $this->emit('showModal');
    }

    public function destroy($id)
    {
        $this->akun_tipe_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        AkunTipe::destroy($this->akun_tipe_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }
}
