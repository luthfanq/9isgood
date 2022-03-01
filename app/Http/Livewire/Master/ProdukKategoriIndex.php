<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\ProdukKategori;
use Livewire\Component;

class ProdukKategoriIndex extends Component
{
    protected $listeners = [
        'edit'=>'edit'
    ];

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
    }

    public function store()
    {
        $this->validate([
            'kode_lokal'=>'required',
            'nama'=>'required'
        ]);

        ProdukKategori::updateOrCreate(
            [
                'id'=>$this->idKategoriProduk,
            ],
            [
                'kode_lokal'=>$this->kode_lokal,
                'nama'=>$this->nama,
                'keterangan'=>$this->keterangan,
            ]);
    }

    public function destroy($id)
    {
        $this->kategori_id = $id;
    }

    public function confirmDestroy()
    {
        ProdukKategori::destroy($this->kategori_id);
        $this->emit('close_confirm');
    }
}
