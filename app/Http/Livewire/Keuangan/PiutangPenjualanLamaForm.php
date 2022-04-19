<?php

namespace App\Http\Livewire\Keuangan;

use App\Haramain\Repository\Penjualan\PenjualanLamaRepository;
use App\Models\Keuangan\PiutangPenjualanLama;
use App\Models\KonfigurasiJurnal;
use App\Models\Master\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PiutangPenjualanLamaForm extends Component
{
    public function render()
    {
        return view('livewire.keuangan.piutang-penjualan-lama-form');
    }

    protected $listeners = [
        'set_customer'
    ];

    public $piutang_id;
    public $mode = 'create', $update=false;
    public $tahun_nota, $customer_id, $total_piutang, $keterangan;
    public $total_piutang_rupiah;

    // var detail
    public $data_detail = [];
    public $nomor_nota, $tgl_nota, $total_bayar;
    public $penjualan_id;
    public $customer_nama;
    public $index;

    public function mount($piutangLamaId = null)
    {
        if ($piutangLamaId){
            // initiate
            $piutang = PiutangPenjualanLama::query()->with('piutangPenjualanLamaDetail.penjualan')->find($piutangLamaId);
            $this->piutang_id = $piutang->id;
            $this->nomor_nota = $piutang->penjualan->kode;
            $this->total_piutang = $piutang->total_piutang;
            $this->keterangan = $piutang->keterangan;

            foreach ($piutang->piutangPenjualanLamaDetail as $item) {
                $this->data_detail[]=[
                    'penjualan_id'=>$item->penjualan_id,
                    'tgl_nota'=>$item->penjualan->tgl_nota,
                    'total_bayar'=>$item->total_bayar
                ];
            }
            $this->setTotalPiutang();
        }
        $this->setJurnalTransaksi();
    }

    public $piutang_dagang, $modal_awal;

    protected function setJurnalTransaksi()
    {
        $this->piutang_dagang = KonfigurasiJurnal::query()->find('piutang_usaha')->akun_id;
        $this->modal_awal = KonfigurasiJurnal::query()->find('prive_modal_awal')->akun_id;
    }

    public function set_customer(Customer $customer)
    {
        $this->customer_id = $customer->id;
        $this->customer_nama = $customer->nama;
    }

    public function setTotalPiutang()
    {
        $this->total_piutang = array_sum(array_column($this->data_detail, 'total_bayar'));
        $this->total_piutang_rupiah = rupiah_format($this->total_piutang);
    }

    public function addLine()
    {
        $this->data_detail[] = [
            'nomor_nota'=>$this->nomor_nota,
            'tgl_nota'=>$this->tgl_nota,
            'total_bayar'=>$this->total_bayar
        ];
        $this->setTotalPiutang();
        $this->reset(['penjualan_id', 'tgl_nota', 'total_bayar', 'nomor_nota']);
    }

    public function edit($index)
    {
        $this->index = $index;
        $this->nomor_nota = $this->data_detail[$index]['nomor_nota'];
        $this->tgl_nota = $this->data_detail[$index]['tgl_nota'];
        $this->total_bayar = $this->data_detail[$index]['total_bayar'];
    }

    public function updateLine()
    {
        $index = $this->index;
        $this->data_detail[$index]['nomor_nota'] = $this->nomor_nota;
        $this->data_detail[$index]['tgl_nota'] = $this->tgl_nota;
        $this->data_detail[$index]['total_bayar'] = $this->total_bayar;
        $this->setTotalPiutang();
        $this->reset(['penjualan_id', 'tgl_nota', 'total_bayar', 'nomor_nota']);
    }

    public function destroy($index)
    {
        // remove line transaksi
        unset($this->data_detail[$index]);
        $this->data_detail = array_values($this->data_detail);
    }

    protected function dataValidate()
    {
        return $this->validate([
            'piutang_id'=>'nullable',
            'tahun_nota'=>'required',
            'customer_id'=>'required',
            'total_piutang'=>'required',
            'keterangan'=>'nullable',
            'data_detail'=>'required',
            'piutang_dagang'=>'required',
            'modal_awal'=>'required'
        ]);
    }

    public function store()
    {
        $data = $this->dataValidate();
        \DB::beginTransaction();
        try {
            $piutang = (new PenjualanLamaRepository())->store((object)$data);
            \DB::commit();
            redirect()->to(route('penjualan.piutanglama'));
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
            session()->flash('message'. $e);
        }
    }
}
