<?php

namespace App\Http\Livewire\Pembelian;

use App\Haramain\Repository\Pembelian\PembelianCobaRepo;
use App\Haramain\Repository\Pembelian\PembelianInternalRepo;
use App\Models\Keuangan\HargaHppALL;
use App\Models\KonfigurasiJurnal;
use App\Models\Master\Gudang;
use App\Models\Master\Produk;
use App\Models\Master\Supplier;
use App\Models\Purchase\Pembelian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PembelianInternalForm extends Component
{
    use PembelianFormTraits;

    public function render()
    {
        return view('livewire.pembelian.pembelian-internal-form');
    }

    protected $listeners = [
        'set_supplier'=>'setSupplier',
        'set_produk'=>'setProduk'
    ];

    // var master
    public $jenis = 'INTERNAL', $kondisi='baik';

    public function setProduk(Produk $produk)
    {
        $this->produk_id = $produk->id;
        $this->produk_nama = $produk->nama."\n".$produk->kategoriHarga->nama."\n".$produk->cover;
        $this->produk_kode_lokal = $produk->kode_lokal;
        $this->produk_harga = $produk->harga;
        $this->hitungHpp();
        //dd($this->produk_harga);
    }

    public function hitungHpp()
    {
        (int)$this->harga_setelah_hpp = $this->produk_harga * (float)$this->hpp;
    }

    public function hitungSubTotal()
    {
        $this->sub_total = $this->harga_setelah_hpp * $this->jumlah;
    }

    public function addLine()
    {
        $this->validate([
            'produk_nama'=>'required',
            'jumlah'=>'required'
        ]);
        $this->hitungSubTotal();
        $this->data_detail[] = [
            'produk_id'=>$this->produk_id,
            'produk_kode_lokal'=>$this->produk_kode_lokal,
            'produk_nama'=>$this->produk_nama,
            'produk_harga'=>$this->produk_harga,
            'diskon'=>null,
            'harga'=>$this->harga_setelah_hpp,
            'jumlah'=>$this->jumlah,
            'sub_total'=>$this->sub_total
        ];
        // dd($this->harga_setelah_hpp);
        $this->reset(['produk_id', 'produk_kode_lokal', 'produk_nama', 'produk_harga', 'harga_setelah_hpp', 'jumlah', 'sub_total']);
    }

    public function editLine($index)
    {
        $this->update = true;
        $this->index_detail = $index;
        $this->produk_id = $this->data_detail[$index]['produk_id'];
        $this->produk_kode_lokal = $this->data_detail[$index]['produk_kode_lokal'];
        $this->produk_nama = $this->data_detail[$index]['produk_nama'];
        $this->produk_harga = $this->data_detail[$index]['produk_harga'];
        $this->harga_setelah_hpp = $this->data_detail[$index]['harga'];
        $this->jumlah = $this->data_detail[$index]['jumlah'];
        $this->sub_total = $this->data_detail[$index]['sub_total'];
    }

    public function updateLine()
    {
        $this->validate([
            'produk_nama'=>'required',
            'jumlah'=>'required'
        ]);
        $this->hitungSubTotal();
        $index = $this->index_detail;
        $this->data_detail[$index]['produk_id'] = $this->produk_id;
        $this->data_detail[$index]['produk_kode_lokal'] = $this->produk_kode_lokal;
        $this->data_detail[$index]['produk_nama'] = $this->produk_nama;
        $this->data_detail[$index]['produk_harga'] = $this->produk_harga;
        $this->data_detail[$index]['harga'] = $this->harga_setelah_hpp;
        $this->data_detail[$index]['jumlah'] = $this->jumlah;
        $this->data_detail[$index]['sub_total'] = $this->sub_total;
        $this->update = false;
        $this->reset(['produk_id', 'produk_kode_lokal', 'produk_nama', 'produk_harga', 'harga_setelah_hpp', 'jumlah', 'sub_total']);
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
            //$pembelian = (new PembelianInternalRepo())->store((object)$data);
            $pembelian = (new PembelianCobaRepo())->store((object)$data);
            \DB::commit();
            return redirect()->to(route('stock.masuk'));
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
            $pembelian = (new PembelianInternalRepo())->update((object)$data);
            \DB::commit();
            return redirect()->to(route('stock.masuk'));
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
        return null;
    }

}
