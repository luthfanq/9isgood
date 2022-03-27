<?php

namespace App\Http\Livewire\Keuangan\Kasir;

use App\Models\Keuangan\Akun;
use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Keuangan\NeracaSaldo;
use Livewire\Component;

class NeracaSaldoAwal extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit',
        'resetForm',
        'destroy',
        'confirmDestroy'
    ];
    
    public $resetForm = ['akun_id','keterangan'];

    public $akun_id, $keterangan;
    public $akun_id_data, $neraca_id;


    public function render()
    {
        return view('livewire.keuangan.kasir.neraca-saldo-awal');
    }

    
    public function mount()
    {
        $this->akun_id_data = Akun::all();
    }

    public function store()
    {
        $this->validate([
            'akun_id'=>'required',
        ]);

        NeracaSaldo::query()->updateOrCreate(
            [
                'id'=>$this->neraca_id
            ],
            [
                'akun_id'=>$this->akun_id,
                'keterangan'=>$this->keterangan,
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function edit(NeracaSaldo $neraca)
    {
        $this->neraca_id = $neraca->id;
        $this->akun_id = $neraca->akun_id;
        $this->keterangan = $neraca->keterangan;
        $this->emit('showModal');
    }

    public function destroy($id)
    {
        $this->neraca_id = $id;
        $this->emit('showDeleteNotification');
    }
    
    public function confirmDestroy()
    {
        NeracaSaldo::destroy($this->neraca_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }

}
