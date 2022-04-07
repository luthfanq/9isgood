<?php

namespace App\Http\Livewire\Purchase;

use App\Haramain\Repository\Pembelian\PembelianReturRepository;
use App\Models\Purchase\PembelianRetur;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PembelianReturForm extends Purchase
{
    public $pembelian_retur_id, $kondisi;
    public $load_from_stock = false;

    public function render()
    {
        return view('livewire.purchase.pembelian-retur-form');
    }

    public function mount($kondisi = 'baik', $retur=null)
    {
        $this->kondisi = $kondisi;
        $this->jenis = 'BLU';

        if ($retur){
            $pembelian_retur = PembelianRetur::query()->find($retur);

            $this->forMount('update', $pembelian_retur, $pembelian_retur->returDetail);

            $this->hitungTotal();
            $this->hitungTotalBayar();
        }
    }

    public function loadFromStock()
    {
        $this->load_from_stock = true;
    }

    protected function validateData(): array
    {
        $this->total_barang = array_sum(array_column($this->data_detail, 'jumlah'));
        return $this->validate([
            'pembelian_retur_id'=>'nullable',
            'kondisi'=>'required',
            'jenis'=>'required',
            'supplier_id'=>'required',
            'gudang_id'=>'required',
            'tgl_nota'=>'required|date_format:d-M-Y',
            'tgl_tempo'=>'nullable|date_format:d-M-Y',
            'jenis_bayar'=>'required',
            'total_barang'=>'nullable|numeric',
            'ppn'=>'nullable|numeric',
            'biaya_lain'=>'nullable|numeric',
            'total_bayar'=>'required|numeric',
            'keterangan'=>'nullable|string',

            // akun
            'akun_persediaan'=>'required',
            'akun_biaya_lain'=>'required',
            'akun_ppn'=>'required',
            'akun_hutang_dagang'=>'required',
        ]);
    }
    public function store()
    {
        \DB::beginTransaction();
        try {
            PembelianReturRepository::create((object)$this->validateData(), $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
            session()->flash('message', $e);
        }
        return redirect()->route('pembelian');
    }

    public function update()
    {
        \DB::beginTransaction();
        try {
            PembelianReturRepository::update((object)$this->validateData(), $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
            session()->flash('message', $e);
        }
        return redirect()->route('pembelian');
    }
}
