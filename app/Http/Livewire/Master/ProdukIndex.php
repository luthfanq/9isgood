<?php

namespace App\Http\Livewire\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\Produk;
use App\Models\Master\ProdukKategori;
use App\Models\Master\ProdukKategoriHarga;
use Livewire\Component;

class ProdukIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit'=>'edit',
        'resetForm'=>'resetForm',
        'destroy'=>'destroy',
        'confirmDestroy'=>'confirmDestroy'
    ];

    public $produk_id, $kategori, $kategori_harga;
    public $kode, $kode_lokal, $penerbit, $nama, $hal, $cover, $size, $deskripsi;
    public $harga, $hargaRupiah;

    public $resetForm = [
        'produk_id', 'kategori', 'kategori_harga',
        'kode', 'kode_lokal', 'penerbit', 'nama', 'hal', 'cover', 'size', 'deskripsi',
        'harga', 'hargaRupiah'
    ];

    public function render()
    {
        return view('livewire.master.produk-index', [
            'kategori'=>ProdukKategori::all(),
            'kategoriHarga'=>ProdukKategoriHarga::all()
        ]);
    }

    public function edit(Produk $produk)
    {
        $this->produk_id = $produk->id;
        $this->kategori = $produk->kategori_id;
        $this->kategori_harga = $produk->kategori_harga_id;
        $this->kode = $produk->kode;
        $this->kode_lokal = $produk->kode_lokal;
        $this->penerbit = $produk->penerbit;
        $this->nama = $produk->nama;
        $this->hal = $produk->hal;
        $this->cover = $produk->cover;
        $this->size = $produk->size;
        $this->deskripsi = $produk->deskripsi;
        $this->harga = $produk->harga;
    }

    public function store()
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function confirmDestroy()
    {
        //
    }
}
