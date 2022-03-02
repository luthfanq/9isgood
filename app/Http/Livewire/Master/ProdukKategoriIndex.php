<?php

namespace App\Http\Livewire\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\ProdukKategori;
use Livewire\Component;

class ProdukKategoriIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit'=>'edit',
        'resetForm'=>'resetForm',
        'destroy'=>'destroy',
        'confirmDestroy'=>'confirmDestroy'
    ];

    public array $resetForm = ['kategori_id', 'kode_lokal', 'nama', 'keterangan'];

    public $kategori_id, $kode_lokal, $nama, $keterangan;

    public function render()
    {
        return view('livewire.master.produk-kategori-index');
    }

    public function edit(ProdukKategori $produkKategori)
    {
        $this->kategori_id = $produkKategori->id;
        $this->kode_lokal = $produkKategori->kode_lokal;
        $this->nama = $produkKategori->nama;
        $this->keterangan = $produkKategori->keterangan;
        $this->emit('showModal');
    }

    public function store()
    {
        $this->validate([
            'kode_lokal'=>'required',
            'nama'=>'required'
        ]);

        ProdukKategori::updateOrCreate(
            [
                'id'=>$this->kategori_id,
            ],
            [
                'kode_lokal'=>$this->kode_lokal,
                'nama'=>$this->nama,
                'keterangan'=>$this->keterangan,
            ]);
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
    }

    public function destroy($id)
    {
        $this->kategori_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        ProdukKategori::destroy($this->kategori_id);
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatables');
    }
}
