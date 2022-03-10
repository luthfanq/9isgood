<?php

namespace App\Http\Livewire\Keuangan\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Keuangan\AkunKategori;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AkunKategoriIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit',
        'resetForm',
        'destroy',
        'confirmDestroy'
    ];

    public $akun_kategori_id, $kode, $deskripsi, $keterangan;

    public $resetForm = ['akun_kategori_id', 'kode', 'deskripsi', 'keterangan'];

    public function render()
    {
        return view('livewire.keuangan.master.akun-kategori-index');
    }

    public function store()
    {
        $this->validate([
            'kode'=>['required',
                Rule::unique('akun_kategori', 'kode')->ignore($this->akun_kategori_id)
            ],
            'kategori'=>'required|min:3',
            'keterangan'=>''
        ]);

        AkunKategori::updateOrCreate(
            [
                'id'=>$this->akun_kategori_id,
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

    public function edit(AkunKategori $akun)
    {
        $this->akun_kategori_id = $akun->id;
        $this->kode = $akun->kode;
        $this->deskripsi = $akun->deskripsi;
        $this->keterangan = $akun->keterangan;
        $this->emit('showModal');
    }

    public function destroy($id)
    {
        $this->akun_kategori_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        AkunKategori::destroy($this->akun_kategori_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }
}
