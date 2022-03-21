<?php

namespace App\Http\Livewire\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\Pegawai;
use Livewire\Component;

class PegawaiIndex extends Component
{
    use ResetFormTraits;
    protected $listeners = [
        'edit',
        'resetForm',
        'destroy',
        'confirmDestroy'
    ];

    public $pegawai_id, $user_id, $kode, $nama, $gender, $jabatan, $telepon, $alamat, $keterangan;

    public $resetForm = ['pegawai_id', 'user_id', 'kode', 'nama', 'gender', 'jabatan', 'telepon', 'alamat','keterangan'];

    public function render()
    {
        return view('livewire.master.pegawai-index');
    }

    public function kode()
    {
        $pegawai = Pegawai::latest('kode')->first();
        if (!$pegawai){
            $num = 1;
        } else {
            $lastNum = (int) $pegawai->last_num_master;
            $num = $lastNum + 1;
        }
        return "P".sprintf("%05s", $num);
    }

    public function edit(Pegawai $pegawai)
    {
        $this->pegawai_id = $pegawai->id;
        $this->kode = $pegawai->kode;
        $this->nama = $pegawai->nama;
        $this->gender = $pegawai->gender;
        $this->jabatan = $pegawai->jabatan;
        $this->telepon = $pegawai->telepon;
        $this->alamat = $pegawai->alamat;
        $this->keterangan = $pegawai->keterangan;
        $this->emit('showModal');
    }

    public function store()
    {
        $this->validate([
            'nama'=>'required|min:3',
            'gender'=>'required',
            'jabatan'=>'required'
        ]);

        Pegawai::query()->updateOrCreate(
            [
                'id'=>$this->pegawai_id
            ],
            [
                'kode'=> $this->kode ?? $this->kode(),
                'user_id'=> $this->user_id ?? \Auth::id(),
                'nama'=> $this->nama,
                'gender'=>$this->gender,
                'jabatan'=>$this->jabatan,
                'telepon'=>$this->telepon,
                'alamat'=>$this->alamat,
                'keterangan'=>$this->keterangan,
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function destroy($id)
    {
        $this->pegawai_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        Pegawai::destroy($this->pegawai_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }
}
