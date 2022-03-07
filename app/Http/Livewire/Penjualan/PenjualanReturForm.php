<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Master\Gudang;
use Livewire\Component;

class PenjualanReturForm extends Component
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

    public function mount()
    {
        $this->tgl_nota = tanggalan_format(now('ASIA/JAKARTA'));
        $this->tgl_tempo = tanggalan_format(now('ASIA/JAKARTA')->addMonth(2));
        $this->gudang_data = Gudang::all();
    }

    public function render()
    {
        return view('livewire.penjualan.penjualan-retur-form');
    }
}
