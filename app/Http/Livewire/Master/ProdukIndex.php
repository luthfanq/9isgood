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
            'kategori_data'=>ProdukKategori::all(),
            'kategori_harga_data'=>ProdukKategoriHarga::all()
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
        $this->emit('showModal');
    }

    public function kode(): ?string
    {
        $produk = Produk::latest('kode')->first();
        if (!$produk){
            $num = 1;
        } else {
            $lastNum = (int) $produk->last_num_master;
            $num = $lastNum + 1;
        }
        return "P".sprintf("%05s", $num);
    }

    public function store()
    {
        $this->validate([
            'kategori'=>'required',
            'kategori_harga'=>'required',
            'nama'=>'required',
            'harga'=>'required'
        ]);

//        dd($this->kode());

        Produk::query()->updateOrCreate(
            [
                'id'=>$this->produk_id,
            ],
            [
                'kode'=> $this->kode ?? $this->kode(),
                'kategori_id'=>$this->kategori,
                'kategori_harga'=>$this->kategori_harga,
                'kode_lokal'=>$this->kode_lokal,
                'penerbit'=>$this->penerbit,
                'nama'=>$this->nama,
                'hal'=>$this->hal,
                'cover'=>$this->cover,
                'harga'=>$this->harga,
                'size'=>$this->size,
                'deskripsi'=>$this->deskripsi
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatables');
        $this->resetForm();
    }

    public function destroy($id)
    {
        $this->produk_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        Produk::destroy($this->produk_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatables');
    }
}
