<?php

namespace App\Http\Livewire\Pembelian;

use App\Haramain\Repository\Pembelian\PembelianBukuLuarRepo;
use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PembelianLuarForm extends Component
{
    use PembelianFormTraits;
    public function render()
    {
        return view('livewire.pembelian.pembelian-luar-form');
    }

    protected $listeners = [
        'set_supplier'=>'setSupplier',
        'set_produk'=>'setProduk'
    ];

    // var for manipulate
    public $update = false;
    public $mode = 'create';

    // var master
    public $jenis = 'BLU', $kondisi='baik';

    // detail
    public $harga, $diskon;

    public function setProduk(Produk $produk)
    {
        $this->produk_id = $produk->id;
        $this->produk_nama = $produk->nama."\n".$produk->kategoriHarga->nama."\n".$produk->cover;
        $this->produk_kode_lokal = $produk->kode_lokal;
        $this->produk_harga = $produk->harga;
        //dd($this->produk_harga);
    }

    public function setSubTotal()
    {
        $this->sub_total = (int)$this->harga * (int)$this->jumlah;
    }

    public function addLine()
    {
        $this->validate([
            'produk_nama'=>'required',
            'jumlah'=>'required'
        ]);
        $this->data_detail[] = [
            'produk_id'=>$this->produk_id,
            'produk_kode_lokal'=>$this->produk_kode_lokal,
            'produk_nama'=>$this->produk_nama,
            'produk_harga'=>$this->produk_harga,
            'diskon'=>null,
            'harga'=>$this->harga,
            'jumlah'=>$this->jumlah,
            'sub_total'=>$this->sub_total
        ];
        // dd($this->harga_setelah_hpp);
        $this->reset(['produk_id', 'produk_kode_lokal', 'produk_nama', 'produk_harga', 'harga', 'jumlah', 'sub_total']);
    }

    public function editLine($index)
    {
        $this->update = true;
        $this->index_detail = $index;
        $this->produk_id = $this->data_detail[$index]['produk_id'];
        $this->produk_kode_lokal = $this->data_detail[$index]['produk_kode_lokal'];
        $this->produk_nama = $this->data_detail[$index]['produk_nama'];
        $this->produk_harga = $this->data_detail[$index]['produk_harga'];
        $this->harga = $this->data_detail[$index]['harga'];
        $this->jumlah = $this->data_detail[$index]['jumlah'];
        $this->sub_total = $this->data_detail[$index]['sub_total'];
    }

    public function updateLine()
    {
        $this->validate([
            'produk_nama'=>'required',
            'jumlah'=>'required'
        ]);
        $index = $this->index_detail;
        $this->data_detail[$index]['produk_id'] = $this->produk_id;
        $this->data_detail[$index]['produk_kode_lokal'] = $this->produk_kode_lokal;
        $this->data_detail[$index]['produk_nama'] = $this->produk_nama;
        $this->data_detail[$index]['produk_harga'] = $this->produk_harga;
        $this->data_detail[$index]['harga'] = $this->harga;
        $this->data_detail[$index]['jumlah'] = $this->jumlah;
        $this->data_detail[$index]['sub_total'] = $this->sub_total;
        $this->update = false;
        $this->reset(['produk_id', 'produk_kode_lokal', 'produk_nama', 'produk_harga', 'harga', 'jumlah', 'sub_total']);
    }

    public function destroyLine($index)
    {
        // remove line transaksi
        unset($this->data_detail[$index]);
        $this->data_detail = array_values($this->data_detail);
    }

    public function store()
    {
        //dd($this->data_detail);
        $data = $this->getTotalBarang();
        try {
            $pembelian = (new PembelianBukuLuarRepo())->store((object)$data);
            \DB::commit();
            return redirect()->to(route('pembelian'));
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
        return null;
    }
    public function update()
    {
        //dd($this->data_detail);
        $data = $this->getTotalBarang();
        try {
            $pembelian = (new PembelianBukuLuarRepo())->update((object)$data);
            \DB::commit();
            return redirect()->to(route('pembelian'));
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
        return null;
    }
}
