<?php

namespace App\Http\Livewire\Penjualan;

use Livewire\Component;

class PenjualanReportIndex extends Component
{
    public function render()
    {
        return view('livewire.penjualan.penjualan-report-index');
    }

    public $tglAwal, $tglAkhir;

    public function mount()
    {
        $this->tglAwal= tanggalan_format(tanggalan_format(now('ASIA/JAKARTA')));
        $this->tglAkhir= tanggalan_format(tanggalan_format(now('ASIA/JAKARTA')));
    }

    public function setTanggal()
    {
        $this->emit('setTanggal', $this->tglAwal, $this->tglAkhir);
    }

    public function printPeriode()
    {
        redirect()->to(route('penjualan.report.bydate', [$this->tglAwal, $this->tglAkhir]));
    }
}
