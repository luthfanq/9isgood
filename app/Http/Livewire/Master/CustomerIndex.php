<?php

namespace App\Http\Livewire\Master;

use App\Haramain\Traits\LivewireTraits\ResetFormTraits;
use App\Models\Master\Customer;
use Livewire\Component;

class CustomerIndex extends Component
{
    use ResetFormTraits;

    protected $listeners = [
        'edit'=>'edit',
        'resetForm'=>'resetForm',
        'destroy'=>'destroy',
        'confirmDestroy'=>'confirmDestroy'
    ];

    public $customer_id, $kode, $nama, $diskon, $telepon, $alamat, $keterangan;

    public $resetForm= [
        'customer_id', 'kode', 'nama', 'diskon', 'telepon', 'alamat', 'keterangan'
    ];

    public function render()
    {
        return view('livewire.master.customer-index');
    }

    public function kode()
    {
        $customer = Customer::latest('kode')->first();
        if (!$customer){
            $num = 1;
        } else {
            $lastNum = (int) $customer->last_num_master;
            $num = $lastNum + 1;
        }
        return "C".sprintf("%05s", $num);
    }

    public function edit(Customer $customer)
    {
        $this->customer_id = $customer->id;
        $this->kode = $customer->kode;
        $this->nama = $customer->nama;
        $this->diskon = $customer->diskon;
        $this->telepon = $customer->telepon;
        $this->alamat = $customer->alamat;
        $this->keterangan = $customer->keterangan;
        $this->emit('showModal');
    }

    public function store()
    {
        $this->validate([
            'nama'=>'required|min:3',
            'diskon'=>'numeric'
        ]);

        Customer::updateOrCreate(
            [
                'id'=>$this->customer_id,
            ],
            [
                'kode'=>$this->kode ?? $this->kode(),
                'nama'=>$this->nama,
                'diskon'=>$this->diskon,
                'telepon'=>$this->telepon,
                'alamat'=>$this->alamat,
                'keterangan'=>$this->keterangan
            ]
        );
        $this->emit('hideModal');
        $this->emit('refreshDatatable');
        $this->resetForm();
    }

    public function destroy($id)
    {
        $this->customer_id = $id;
        $this->emit('showDeleteNotification');
    }

    public function confirmDestroy()
    {
        Customer::destroy($this->jenis_id);
        $this->resetForm();
        $this->emit('hideDeleteNotification');
        $this->emit('close_confirm');
        $this->emit('refreshDatatables');
    }
}
