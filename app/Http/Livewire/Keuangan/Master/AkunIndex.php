<?php

namespace App\Http\Livewire\Keuangan\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Keuangan\Akun;
use App\Models\Keuangan\AkunKategori;
use App\Models\Keuangan\AkunTipe;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AkunIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit',
        'resetForm',
        'destroy',
        'confirmDestroy'
    ];

    public $resetForm = ['akun_id', 'akun_kategori_id', 'akun_tipe_id', 'kode', 'deskripsi', 'keterangan'];

    public $akun_id, $akun_kategori_id, $akun_tipe_id;
    public $kode, $deskripsi, $keterangan;

    public $akun_kategori_data, $akun_tipe_data;

    public function render()
    {
        return view('livewire.keuangan.master.akun-index');
    }

    public function mount()
    {
        $this->akun_kategori_data = AkunKategori::all();
        $this->akun_tipe_data = AkunTipe::all();
    }

    public function store()
    {
        $this->validate([
            'akun_kategori_id'=>'required',
            'akun_tipe_id'=>'required',
            'kode'=>'required',
            'deskripsi'=>'required|min:3'
        ]);

        Akun::query()->updateOrCreate(
            [
                'id'=>$this->akun_id
            ],
            [
                'akun_kategori_id'=>$this->akun_kategori_id,
                'akun_tipe_id'=>$this->akun_tipe_id,
                'kode'=>$this->kode,
                'deskripsi'=>$this->deskripsi,
                'keterangan'=>$this->keterangan,
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function edit(Akun $akun)
    {
        $this->akun_id = $akun->id;
        $this->akun_kategori_id = $akun->akun_kategori_id;
        $this->kode = $akun->kode;
        $this->akun_tipe_id = $akun->akun_tipe_id;
        $this->deskripsi = $akun->deskripsi;
        $this->keterangan = $akun->keterangan;
        $this->emit('showModal');
    }

    public function destroy($id)
    {
        $this->akun_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        Akun::destroy($this->akun_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }
}
