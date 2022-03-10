<?php

namespace App\Http\Livewire\Keuangan\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Keuangan\Rekanan;
use Livewire\Component;

class RekananIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit',
        'resetForm',
        'destroy',
        'confirmDestroy'
    ];

    public $rekanan_id, $kode, $nama, $telepon, $alamat, $keterangan;

    public $resetForm = ['rekanan_id', 'kode', 'nama', 'telepon', 'alamat', 'keterangan'];

    public function render()
    {
        return view('livewire.keuangan.master.rekanan-index');
    }

    public function kode()
    {
        $rekanan = Rekanan::latest('kode')->first();
        if (!$rekanan){
            $num = 1;
        } else {
            $lastNum = (int) $rekanan->last_num_master;
            $num = $lastNum + 1;
        }
        return "R".sprintf("%05s", $num);
    }

    public function store()
    {
        $this->validate([
            'nama'=>'required',
        ]);
        if ($this->rekanan_id)
        {
            Rekanan::query()->find($this->rekanan_id)->update([
                'nama'=>$this->nama,
                'telepon'=>$this->telepon,
                'alamat'=>$this->alamat,
                'keterangan'=>$this->keterangan,
            ]);
        }
        else
        {
            Rekanan::query()->create([
                'kode'=>$this->kode(),
                'nama'=>$this->nama,
                'telepon'=>$this->telepon,
                'alamat'=>$this->alamat,
                'keterangan'=>$this->keterangan,
            ]);
        }
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function edit(Rekanan $rekanan)
    {
        $this->rekanan_id = $rekanan->id;
        $this->nama = $rekanan->nama;
        $this->telepon = $rekanan->telepon;
        $this->alamat = $rekanan->alamat;
        $this->keterangan = $rekanan->keterangan;
        $this->emit('showModal');
    }

    public function destroy($id)
    {
        $this->rekanan_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        Rekanan::destroy($this->rekanan_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatable');
    }
}
