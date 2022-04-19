<?php

namespace App\Http\Livewire\Keuangan;

use App\Models\Keuangan\PiutangPenjualanLama;
use App\Models\Master\Customer;
use Livewire\Component;

class PiutangPenjualanLamaForm extends Component
{
    public function render()
    {
        return view('livewire.keuangan.piutang-penjualan-lama-form');
    }

    public $piutang_id;
    public $mode = 'create', $update=false;
    public $tahun_nota, $customer_id, $total_piutang, $keterangan;

    // var detail
    public $data_detail = [];
    public $nomor_nota, $tgl_nota, $total_bayar;
    public $penjualan_id;
    public $customer_nama;

    public function mount($piutangLamaId = null)
    {
        if ($piutangLamaId){
            // initiate
            $piutang = PiutangPenjualanLama::query()->find($piutangLamaId);
            $this->piutang_id = $piutang->id;
            $this->customer_id = $piutang->customer_id;
            $this->total_piutang = $piutang->total_piutang;
            $this->keterangan = $piutang->keterangan;

            foreach ($piutang->piutangPenjualanLamaDetail as $item) {
                $this->data_detail[]=[
                    'penjualan_id'=>$item->penjualan_id,
                    'tgl_nota'=>$item->penjualan->tgl_nota,
                    'total_bayar'=>$item->total_bayar
                ];
            }
        }
    }

    public function setCustomer(Customer $customer)
    {
        //
    }
}
