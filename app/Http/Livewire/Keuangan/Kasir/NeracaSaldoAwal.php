<?php

namespace App\Http\Livewire\Keuangan\Kasir;

use App\Models\Keuangan\Akun;
use App\Haramain\Traits\LivewireTraits\SetAkunTraits;
use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Keuangan\NeracaSaldoAwalModel;
use Livewire\Component;
use Illuminate\Validation\Rule;


class NeracaSaldoAwal extends Component
{
    use ResetFormTraits, setAkunTraits;

    protected $listeners = [
        'set_akun' => 'setAkun',
        'edit',
        'resetForm',
        'destroy',
        'confirmDestroy'
    ];
    
    public string $mode= 'create';

    // enable update proses
    public bool $update = false;


    public $saldo_awal, $akun_id, $akun_nama, $keterangan;
    public $nominal_debet, $nominal_kredit, $user_id;


    public $resetForm = ['saldo_awal', 'akun_id', 'akun_nama', 'keterangan', 'nominal_debet', 'nominal_kredit', 'user_id'];
    

    public function render()
    {
        return view('livewire.keuangan.kasir.neraca-saldo-awal');
    }


    public function store()
    {
        $this->validate([
            'akun_id'=>'required',
            'saldo_awal'=> ['required', Rule::unique('mysql.nerasa_saldo_awal', 'saldo_awal')->ignore($this->saldo_awal, 'saldo_awal')],
        ]);

        NeracaSaldo::query()->updateOrCreate(
            [
                'saldo_awal'=>$this->saldo_awal
            ],
            [
                'akun_id'=>$this->akun_id,
                'user_id'=>\Auth::id(),
                'nominal_debet'=>$this->nominal_debet,
                'nominal_kredit'=>$this->nominal_kredit,
                'keterangan'=>$this->keterangan,
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function edit(NeracaSaldo $neraca)
    {
        $this->saldo_awal = $neraca->saldo_awal;
        $this->akun_id = $neraca->akun_id;
        $this->akun_nama = $neraca->akun->deskripsi;
        $this->user_id = $neraca->user_id;
        $this->nominal_debet = $neraca->nominal_debet;
        $this->nominal_kredit = $neraca->nominal_kredit;
        $this->keterangan = $neraca->keterangan;
    }

    public function destroy($id)
    {
        $this->saldo_awal = $id;
        $this->emit('showDeleteNotification');
    }
    
    public function confirmDestroy()
    {
        NeracaSaldo::destroy($this->saldo_awal);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }

}
