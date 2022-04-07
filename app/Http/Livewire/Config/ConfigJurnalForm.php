<?php

namespace App\Http\Livewire\Config;

use App\Models\Keuangan\Akun;
use App\Models\KonfigurasiJurnal;
use Livewire\Component;

class ConfigJurnalForm extends Component
{
    public $jurnal;
    public $configJurnal;
    public $akun_id;
    public $akun_name;
    public $setConfigForAkun;

    protected $listeners = [
        'set_akun'
    ];

    public function render()
    {
        return view('livewire.config.config-jurnal-form');
    }

    public function mount()
    {
        $this->configJurnal = KonfigurasiJurnal::all();
        foreach ($this->configJurnal as $item){
            $this->akun_id[$item->config] = $item->akun_id;
            $this->akun_name[$item->config] = $item->akun->deskripsi ?? null;
        }
    }

    public function setConfigForAkun($config)
    {
        $this->setConfigForAkun = $config;
    }

    public function set_akun(Akun $akun)
    {
        $this->akun_id[$this->setConfigForAkun] = $akun->id;
        $this->akun_name[$this->setConfigForAkun] = $akun->deskripsi ?? null;
    }

    public function update(string $config)
    {
        $this->validate([
            "akun_id.{$config}"=>'required'
        ]);
        //dd($this->akun_id[$config]);
        $query = KonfigurasiJurnal::query()->find($config);
        $query->update([
            'akun_id'=>$this->akun_id[$config]
        ]);
        $this->reset(['setConfigForAkun']);
    }
}
