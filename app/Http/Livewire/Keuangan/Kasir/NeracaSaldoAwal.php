<?php

namespace App\Http\Livewire\Keuangan\Kasir;

use App\Http\Livewire\Keuangan\Jurnal\JurnalUmumForm;

class NeracaSaldoAwal extends JurnalUmumForm
{
    public function mount($jurnalUmumId = null)
    {
        $this->tgl_jurnal = tanggalan_format(now('ASIA/JAKARTA'));
        $this->is_persediaan_awal = true;
    }

}
