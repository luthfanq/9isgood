<?php

namespace App\Http\Livewire;

use App\Models\Keuangan\Akun;
use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\KonfigurasiJurnal;
use Illuminate\Validation\Rule;
use Livewire\Component;

class KonfigurasiJurnalIndex extends Component
{
    use ResetFormTraits;
    protected $listeners = [
        'set_akun' => 'setAkun',
        'edit',
        'resetForm',
        'destroy',
        'confirmDestroy'
    ];

    public function setAkun(Akun $akun)
    {
        $akun = $this->setAkun($akun);
        $this->akun_nama = $akun->deskripsi;
    }

    public $config, $akun_id, $keterangan;

    public $resetForm = ['config', 'akun_id', 'keterangan'];

    public function render()
    {
        return view('livewire.konfigurasi-jurnal-index');
    }

    public function edit(KonfigurasiJurnal $konfigurasiJurnal)
    {
        $this->config = $konfigurasiJurnal->config;
        $this->akun_id = $konfigurasiJurnal->akun_id;
        $this->keterangan = $konfigurasiJurnal->keterangan;
        $this->emit('showModal');
    }

    public function store()
    {
        $this->validate([
            'config'=> ['required', Rule::unique('konfigurasi_jurnal', 'config')->ignore($this->config)],
            'akun_id'=>'required'
        ]);
        KonfigurasiJurnal::query()->updateOrCreate(
            [
                'config'=>$this->config,
            ],
            [
                'akun_id'=>$this->akun_id,
                'keterangan'=>$this->keterangan
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function destroy($id)
    {
        $this->config = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        KonfigurasiJurnal::destroy($this->config);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }
}
