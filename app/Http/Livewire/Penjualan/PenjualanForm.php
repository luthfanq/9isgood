<?php

namespace App\Http\Livewire\Penjualan;

use App\Haramain\Repository\PenjualanRepository;
use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\Customer;
use App\Models\Master\Gudang;
use App\Models\Master\Produk;
use App\Models\Sales\Penjualan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Mixed_;

class PenjualanForm extends Component
{
    protected $listeners = [
        'set_customer'=>'setCustomer',
        'set_produk'=>'setProduk'
    ];

    public array $penjualan_detail = [];
    public bool $update =false;
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

    public function render(): View
    {
        return view('livewire.penjualan.penjualan-form');
    }

    public function mount(Penjualan $penjualan = null): void
    {
        $this->tgl_nota = tanggalan_format(now('ASIA/JAKARTA'));
        $this->tgl_tempo = tanggalan_format(now('ASIA/JAKARTA')->addMonth(2));
        $this->gudang_data = Gudang::all();

        if ($penjualan)
        {
            // mode update true
            $this->update = true;

            // mount customer data
            $this->customer_id = $penjualan->customer_id;
            $this->customer_nama = $penjualan->customer->nama;
            $this->customer_diskon = $penjualan->customer->diskon;

            // mount single data
            $this->jenis_bayar = $penjualan->jenis_bayar;
            $this->tgl_nota = tanggalan_format($penjualan->tgl_nota);
            $this->tgl_tempo = tanggalan_format($penjualan->tgl_tempo);
            $this->gudang_id = $penjualan->gudang_id;
            $this->keterangan = $penjualan->keterangan;

            // mount detail
            foreach ($penjualan->penjualanDetail as $row)
            {
                $this->penjualan_detail [] = [
                    'produk_id'=>$row->produk_id,
                    'kode_lokal'=>$row->produk->kode_lokal,
                    'nama_produk'=>$row->produk->nama."\n".$row->produk->cover."\n".$row->produk->hal,
                    'harga'=>$row->harga,
                    'jumlah'=>$row->jumlah,
                    'diskon'=>$row->diskon,
                    'sub_total'=>$row->sub_total
                ];
            }
            $this->hitungTotal();
            $this->hitungTotalBayar();
        }
    }

    /**************
     * Set Customer and Produk
     ***************/
    public function setCustomer(Customer $customer)
    {
        $this->customer_id = $customer->id;
        $this->customer_nama = $customer->nama;
    }

    public function setProduk(Produk $produk)
    {
        $this->idProduk = $produk->id;
        $this->namaProduk = $produk->nama."\n".$produk->cover."\n".$produk->hal;
        $this->kodeLokalProduk = $produk->kode_lokal;
        $this->halProduk = $produk->hal;
        $this->coverProduk = $produk->cover;
        $this->hargaProduk = $produk->harga;
        $this->diskonProduk = $this->customer_diskon;
        $this->detailHarga = rupiah_format($this->hargaProduk);
        $this->hitungDiskon();
        $this->emit('hideProduk');
    }

    /****************************
     * Helper for table
     *****************************/

    /**
     * Menghitung Diskon
     */
    public function hitungDiskon(): void
    {
        $this->detailDiskon = (int)$this->hargaProduk - ((int)$this->hargaProduk * ((int)$this->diskonProduk)/100);
        $this->detailDiskonHarga = rupiah_format($this->detailDiskon);
    }

    /**
     * Menghitung nilai sub total
     */
    public function hitungSubTotal(): void
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

    public function resetForm(): void
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

    public function addLine(): void
    {
        $this->validate([
            'namaProduk'=>'required',
            'detailHarga'=>'required',
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
        $this->resetForm();
    }

    public function editLine($index): void
    {
        $this->update = true;
        $this->indexDetail = $index;
        $this->idProduk = $this->penjualan_detail[$index]['produk_id'];
        $this->namaProduk = $this->penjualan_detail[$index]['nama_produk'];
        $this->hargaProduk = $this->penjualan_detail[$index]['harga'];
        $this->detailHarga = rupiah_format($this->hargaProduk);
        $this->jumlahProduk = $this->penjualan_detail[$index]['jumlah'];
        $this->diskonProduk = $this->penjualan_detail[$index]['diskon'];
        $this->subTotalProduk = $this->penjualan_detail[$index]['sub_total'];
        $this->hitungSubTotal();
    }

    public function updateLine(): void
    {
        $this->validate([
            'idProduk'=>'required',
            'jumlahProduk'=>'required'
        ]);

        $index = $this->indexDetail;
        $this->penjualan_detail[$index]['produk_id'] = $this->idProduk;
        $this->penjualan_detail[$index]['nama_produk'] = $this->namaProduk;
        $this->penjualan_detail[$index]['harga'] = $this->hargaProduk;
        $this->penjualan_detail[$index]['jumlah'] = $this->jumlahProduk;
        $this->penjualan_detail[$index]['diskon'] = $this->diskonProduk;
        $this->penjualan_detail[$index]['sub_total'] = $this->subTotalProduk;
        $this->hitungSubTotal();
        $this->resetForm();
        $this->update = false;
        $this->hitungTotal();
        $this->hitungTotalBayar();
    }

    public function destroyLine($index): void
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

    /**
     * validate data before update or insert
     * @return array
     */
    protected function validateData(): array
    {
        $this->total_barang = array_sum(array_column($this->penjualan_detail, 'jumlah'));
        return $this->validate([
            'penjualan_id'=>'nullable',
            'customer_id'=>'required',
            'gudang_id'=>'required',
            'tgl_nota'=>'required|date_format:d-M-Y',
            'tgl_tempo'=>'nullable|date_format:d-M-Y',
            'jenis_bayar'=>'required',
            'total_barang'=>'nullable|numeric',
            'ppn'=>'nullable|numeric',
            'biaya_lain'=>'nullable|numeric',
            'total_bayar'=>'required|numeric',
            'keterangan'=>'nullable|string'
        ]);
    }

    /**
     * Store data
     * if fail, show message
     */
    public function store(): void
    {
        \DB::beginTransaction();
        try {
            PenjualanRepository::create((object) $this->validateData(), $this->penjualan_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
            session()->flash('message', $e);
        }
    }

    public function update(): void
    {
        \DB::beginTransaction();
        try {
            PenjualanRepository::update((object) $this->validateData(), $this->penjualan_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
            session()->flash('message', $e);
        }
    }
}
