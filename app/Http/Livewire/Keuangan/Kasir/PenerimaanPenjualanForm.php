<?php

namespace App\Http\Livewire\Keuangan\Kasir;

use App\Haramain\Traits\LivewireTraits\SetCustomerTraits;
use App\Models\Keuangan\KasirPenjualan;
use App\Models\Master\Customer;
use Livewire\Component;

class PenerimaanPenjualanForm extends Component
{
    use SetCustomerTraits;

    protected $listeners = [];

    public $penerimaan_penjualan_id;
    public $customer_id;
    public $total_nota, $total_tunai, $total_piutang;

    public $detail, $penjualan_id;

    public function render()
    {
        return view('livewire.keuangan.kasir.penerimaan-penjualan-form');
    }

    public function mount($penerimaan_penjualan_id = null)
    {
        if ($penerimaan_penjualan_id){
            $penerimaan_penjualan = KasirPenjualan::query()->find($penerimaan_penjualan_id);
            $this->penerimaan_penjualan_id = $penerimaan_penjualan_id;
            $this->total_nota = $penerimaan_penjualan->total_nota;
            $this->total_tunai = $penerimaan_penjualan->total_tunai;
            $this->total_piutang = $penerimaan_penjualan->total_piutang;
            $this->setCustomer($penerimaan_penjualan->customer_id);

            $this->detail = $penerimaan_penjualan->kasir_penjualan_detail();
        }
    }

    public function store()
    {
        //
    }
}
