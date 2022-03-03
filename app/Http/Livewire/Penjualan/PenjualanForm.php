<?php

namespace App\Http\Livewire\Penjualan;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\Gudang;
use Livewire\Component;

class PenjualanForm extends Component
{
    protected $listeners = [
        ''
    ];

    public $penjualan_detail = [];
    public $update =false;
    public $gudang_data;
    public $indexDetail;
    public $mode = 'create';
    public $penjualan_id;

    // properti master
    public $kode, $customer_id, $customer_nama, $customer_diskon, $gudang_id, $user_id;
    public $tgl_nota, $tgl_tempo, $jenis_bayar, $status_bayar, $total_barang, $ppn, $biaya_lain, $total_bayar;
    public $keterangan, $print;
    public $total, $total_rupiah, $total_bayar_rupiah;

    // properti detail
    public $detail_id, $idProduk, $namaProduk, $kodeLokalProduk, $coverProduk, $halProduk, $hargaProduk, $diskonProduk, $jumlahProduk, $subTotalProduk;
    public $detailProduk, $detailHarga, $detailDiskon, $detailDiskonHarga, $detailSubTotal;

    public function render()
    {
        return view('livewire.penjualan.penjualan-form');
    }

    public function mount($penjualanid = null)
    {
        $this->tgl_nota = tanggalan_format(now('ASIA/JAKARTA'));
        $this->tgl_tempo = tanggalan_format(now('ASIA/JAKARTA')->addMonth(2));
        $this->gudang_data = Gudang::all();
    }

    /****************************
     * Helper for table
     *****************************/

    /**
     * Menghitung Diskon
     */
    public function hitungDiskon()
    {
        $this->detailDiskon = (int)$this->hargaProduk - ((int)$this->hargaProduk * ((int)$this->diskonProduk)/100);
        $this->detailDiskonHarga = rupiah_format($this->detailDiskon);
    }

    /**
     * Menghitung nilai sub total
     */
    public function hitungSubTotal()
    {
        $this->hitungDiskon();
        $this->subTotalProduk = $this->detailDiskon * (int)$this->jumlahProduk;
        $this->detailSubTotal = rupiah_format($this->subTotalProduk);
    }

    /**
     * Hitung total dari sub_total
     */
    public function hitungTotal() : void
    {
        $this->total = array_sum(array_column($this->penjualan_detail, 'sub_total'));
        $this->total_rupiah = rupiah_format($this->total);
    }

    /**
     * Hitung total bayar
     */
    public function hitungTotalBayar() : void
    {
        $this->total_bayar = (int)$this->total + (int)$this->biaya_lain + (int)$this->ppn;
        $this->total_bayar_rupiah = rupiah_format($this->total_bayar);
    }

    /*****************************
     * Reset Variable from content
     *****************************/

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset([
            'idProduk', 'namaProduk', 'hargaProduk', 'detailHarga', 'diskonProduk', 'detailDiskonHarga', 'jumlahProduk',
            'subTotalProduk', 'detailSubTotal'
        ]);
    }

    /***********************
     * CRUD Table
     ***********************/

    public function addLine()
    {
        $this->validate([
            'idProduk'=>'required',
            'jumlahProduk'=>'required'
        ]);

        $this->penjualan_detail[] = [
            'produk_id'=>$this->idProduk,
            'kode_lokal'=>$this->kodeLokalProduk,
            'nama_produk'=>$this->namaProduk,
            'harga'=>$this->hargaProduk,
            'jumlah'=>$this->jumlahProduk,
            'diskon'=>$this->diskonProduk,
            'sub_total'=>$this->subTotalProduk
        ];
    }

    public function editLine($index)
    {
        $this->update = true;
        $this->indexDetail = $index;
        $this->idProduk = $this->dataDetail[$index]['produk_id'];
        $this->namaProduk = $this->dataDetail[$index]['nama_produk'];
        $this->hargaProduk = $this->dataDetail[$index]['harga'];
        $this->detailHarga = rupiah_format($this->hargaProduk);
        $this->jumlahProduk = $this->dataDetail[$index]['jumlah'];
        $this->diskonProduk = $this->dataDetail[$index]['diskon'];
        $this->subTotalProduk = $this->dataDetail[$index]['sub_total'];
        $this->hitungSubTotal();
    }

    public function updateLine()
    {
        $this->validate([
            'idProduk'=>'required',
            'jumlahProduk'=>'required'
        ]);

        $index = $this->indexDetail;
        $this->dataDetail[$index]['produk_id'] = $this->idProduk;
        $this->dataDetail[$index]['nama_produk'] = $this->namaProduk;
        $this->dataDetail[$index]['harga'] = $this->hargaProduk;
        $this->dataDetail[$index]['jumlah'] = $this->jumlahProduk;
        $this->dataDetail[$index]['diskon'] = $this->diskonProduk;
        $this->dataDetail[$index]['sub_total'] = $this->subTotalProduk;
        $this->hitungSubTotal();
        $this->resetForm();
        $this->update = false;
        $this->hitungTotal();
        $this->hitungTotalBayar();
    }

    public function destroyLine($index)
    {
        // remove line transaksi
        unset($this->penjualan_detail[$index]);
        $this->penjualan_detail = array_values($this->penjualan_detail);
        $this->hitungTotal();
        $this->hitungTotalBayar();
    }

    /**
     * store and Update data to Database
     */

    public function store()
    {
        //
    }

    public function update()
    {
        //
    }
}
