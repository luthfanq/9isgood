<?php

namespace App\Http\Livewire\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\ProdukKategoriHarga;
use Livewire\Component;

class ProdukKategoriHargaIndex extends Component
{
    use ResetFormTraits;

    public $kategori_harga_id, $nama, $keterangan;

    public $resetForm = ['kategori_harga_id', 'nama', 'keterangan'];

    public function render()
    {
        return view('livewire.master.produk-kategori-harga-index');
    }

    public function edit(ProdukKategoriHarga $produkKategoriHarga)
    {
        $this->kategori_harga_id = $produkKategoriHarga->id;
        $this->nama = $produkKategoriHarga->nama;
        $this->keterangan = $produkKategoriHarga->keterangan;
    }

    public function store()
    {
        ProdukKategoriHarga::query()->updateOrCreate(
            [
                'id'=>$this->kategori_harga_id
            ],
            [
                'nama'=>$this->nama,
                'keterangan'=>$this->keterangan
            ]
        );
    }

    public function destroy($id)
    {
        $this->kategori_harga_id = $id;
    }

    public function comfirmDestroy()
    {
        ProdukKategoriHarga::destroy($this->kategori_harga_id);
    }
}
