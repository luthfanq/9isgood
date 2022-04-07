<?php

namespace App\Http\Livewire\Purchase;

use App\Models\Master\Gudang;
use App\Models\Master\Produk;
use App\Models\Master\Supplier;
use App\Models\Purchase\Pembelian;
use Livewire\Component;

class PembelianInternalForm extends Component
{
    public $pembelian_internal_id;
    public $update = false;

    public float $hpp = 0.6;

    protected $listeners = [
        'set_supplier',
        'set_produk'
    ];

    public $gudang_data = [];

    public function render()
    {
        return view('livewire.purchase.pembelian-internal-form');
    }

    public $akun_persediaan;

    public function mount($pembelian = null)
    {
        $this->gudang_data = Gudang::all();
        $this->tgl_masuk = tanggalan_format(now('ASIA/JAKARTA'));
        if ($pembelian){
            $this->pembelian_internal_id = $pembelian;
            $pembelian_internal = Pembelian::query()->find($pembelian);
        }
    }

    // supplier initiate variable
    public $supplier;
    public $supplier_id, $supplier_nama;

    /**
     * @param Supplier $supplier
     */
    public function setSupplier(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->supplier_id = $supplier->id;
        $this->supplier_nama = $supplier->nama;
    }

    // produk initiate variable
    public $produk;
    public $produk_id, $produk_nama, $produk_harga, $produk_harga_hpp, $produk_cover, $produk_hal;
    public $produk_kategori_harga, $produk_kategori, $produk_kode_lokal;

    /**
     * @param Produk $produk
     */
    public function setProduk(Produk $produk)
    {
        $this->produk = $produk;
        $this->produk_id = $produk->id;
        $this->produk_nama = $produk->nama;
        $this->produk_harga = $produk->harga;
        $this->produk_harga_hpp = $produk->harga * $this->hpp;
        $this->produk_cover = $produk->cover;
        $this->produk_hal = $produk->hal;
        $this->produk_kategori_harga = $produk->kategoriHarga->nama;
        $this->produk_kategori = $produk->kategori->nama;
    }

    // initiate variable for detail transaction line
    public $detail = [];
    public $jumlah;

    public function addLine()
    {
        $this->validate([
            'produk_id'=>'required',
            'jumlah'=>'required'
        ]);
        $this->detail[] = [
            'produk_id'=>$this->produk_id,
            'kode_lokal'=>$this->produk_kode_lokal,
            'nama_produk'=>$this->produk_nama,
            'harga'=>$this->produk_harga,
            'harga_hpp'=>$this->produk_harga_hpp,
            'jumlah'=>$this->jumlah,
            'sub_total'=>$this->produk_harga_hpp * $this->jumlah,
        ];
    }

    // initiate for edit line
    public $index;
    public $sub_total;

    /**
     * @param $index
     */
    public function editLine($index)
    {
        $this->update = true;
        $this->index = $index;
        $this->produk = $this->detail[$index]['produk_id'];
        $this->produk_nama = $this->detail[$index]['nama_produk'];
        $this->produk_harga = $this->detail[$index]['harga'];
        $this->produk_harga_hpp = $this->detail[$index]['harga_hpp'];
        $this->jumlah = $this->jumlah[$index]['jumlah'];
        $this->sub_total = $this->detail[$index]['sub_total'];
    }

    public function updateLine()
    {
        $index = $this->index;
        $this->detail[$index]['produk_id'] = $this->produk_id;
        $this->detail[$index]['nama_produk'] = $this->produk_nama;
        $this->detail[$index]['harga'] = $this->produk_harga;
        $this->detail[$index]['harga_hpp'] = $this->produk_harga_hpp;
        $this->detail[$index]['jumlah'] = $this->jumlah;
        $this->detail[$index]['sub_total'] = $this->sub_total;
        $this->update = false;
    }

    public function removeLine($index)
    {
        // remove line transaksi
        unset($this->detail[$index]);
        $this->detail = array_values($this->detail);
    }

    public $gudang_id, $tgl_masuk, $tgl_tempo, $nomor_nota, $surat_jalan;
    public $jenis_bayar, $status_bayar;
    public $total_barang, $total_bayar;
    public $jenis = 'INTERNAL';
    public $keterangan;

    /**
     * @return array
     */
    protected function setData()
    {
        return $this->validate([
            'pembelian_internal_id'=>'nullable|int',
            'detail'=>'required|array',
            'jenis'=>'required',
            'supplier_id'=>'required',
            'tgl_masuk'=>'required',
            'tgl_tempo'=>'required',
            'surat_jalan'=>'required',
            'jenis_bayar'=>'required',
            'status_bayar'=>'required',
            'total_barang'=>'required',
            'total_bayar'=>'required',
            'keterangan'=>'required'
        ]);
    }

    public function store()
    {
        //
    }

    public function update()
    {
        //
    }
}
