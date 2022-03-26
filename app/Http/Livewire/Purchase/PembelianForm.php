<?php

namespace App\Http\Livewire\Purchase;

use App\Haramain\Repository\Pembelian\PembelianRepository;
use App\Models\Purchase\Pembelian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PembelianForm extends Purchase
{
    public $pembelian_id;
    public $load_from_stock = false;

    public function render()
    {
        return view('livewire.purchase.pembelian-form');
    }

    public function mount($pembelian = null)
    {
        $pembelian = Pembelian::query()->find($pembelian);

        if ($pembelian){
            $this->pembelian_id = $pembelian;

            $this->forMount('update', $pembelian, $pembelian->pembelianDetail);

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
            'pembelian_id'=>'nullable',
            'supplier_id'=>'required',
            'gudang_id'=>'required',
            'nomor_nota'=>'required',
            'surat_jalan'=>'required',
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
            PembelianRepository::create((object)$this->validateData(), $this->data_detail);
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
            PembelianRepository::update((object)$this->validateData(), $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
            session()->flash('message', $e);
        }
        return redirect()->route('pembelian');
    }
}
