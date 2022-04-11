<?php

namespace App\Http\Livewire\Keuangan\Kasir;

use App\Models\KonfigurasiJurnal;
use App\Models\Master\Customer;
use App\Models\Penjualan\Penjualan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PiutangPenjualanForm extends Component
{
    public function render()
    {
        return view('livewire.keuangan.kasir.piutang-penjualan-form');
    }

    protected $listeners = [
        'setPenjualan',
        'set_customer'=>'setCustomer'
    ];

    // var customer
    public $customer_id, $customer_nama;
    public $tgl_jurnal, $keterangan;

    // var detail
    public $data_detail = [];

    // var jurnal transaksi
    public $modal_piutang_awal; // debet
    public $piutang_usaha; // kredit
    public $ppn_penjualan; // kredit
    public $akun_modal_biaya_lain; // kredit

    public function mount($piutangPenjualanId = null)
    {
        $this->tgl_jurnal = tanggalan_format(now('ASIA/JAKARTA'));
    }

    protected function setAkunJurnal()
    {
        // set aku from config
        $this->modal_piutang_awal = KonfigurasiJurnal::find('modal_piutang_awal')->akun_id;
        $this->piutang_usaha = KonfigurasiJurnal::find('piutang_usaha')->akun_id;
        $this->ppn_penjualan = KonfigurasiJurnal::find('ppn_penjualan')->akun_id;
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer_id = $customer->id;
        $this->customer_nama = $customer->nama;
    }

    public function validateButton()
    {
        $this->validate([
            'customer_id'=>'required'
        ]);
    }

    public function setPenjualan(Penjualan $penjualan)
    {
        $this->data_detail [] = [
            'penjualan_id'=>$penjualan->id,
            'penjualan_kode'=>$penjualan->kode,
            'penjualan_total_bayar'=>$penjualan->total_bayar,
            'penjualan_biaya_lain'=>$penjualan->biaya_lain,
            'penjualan_ppn'=>$penjualan->ppn,
            'penjualan_total'=>$penjualan->total_bayar - (int) $penjualan->biaya_lain - (int) $penjualan->ppn
        ];
    }

    public function destroyLine($index)
    {
        // remove line transaksi
        unset($this->data_detail[$index]);
        $this->data_detail = array_values($this->data_detail);
    }

    public function store()
    {
        $data = $this->validate([
            'tgl_jurnal'=>'required',
            'keterangan'=>'nullable',
            'data_detail'=>'required',
        ]);

        \DB::beginTransaction();
        try {
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
    }
}
