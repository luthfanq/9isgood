<?php

namespace App\Http\Livewire\Penjualan;

use App\Haramain\Repository\Penjualan\PenjualanPureRepo;
use App\Haramain\Repository\PenjualanRepository;
use App\Models\Penjualan\Penjualan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenjualanForm extends Transaksi
{
    public int $penjualan_id;

    public function render(): View
    {
        return view('livewire.penjualan.penjualan-form');
    }

    public function mount($penjualan = null): void
    {
        // initiate
        $penjualan = Penjualan::query()->find($penjualan);

        if ($penjualan)
        {
            $this->penjualan_id = $penjualan->id;
            // mode update true and mount data
            $this->forMount('update', $penjualan, $penjualan->penjualanDetail);

            $this->hitungTotal();
            $this->hitungTotalBayar();
        }
    }

    /**
     * validate data before update or insert
     * @return array
     */
    protected function validateData(): array
    {
        //dd($this->keterangan);
        $this->total_barang = array_sum(array_column($this->data_detail, 'jumlah'));
        return $this->validate([
            'data_detail'=>'array',
            'penjualan_id'=>'nullable',
            'customer_id'=>'required',
            'gudang_id'=>'required',
            'tgl_nota'=>'required|date_format:d-M-Y',
            'tgl_tempo'=>'nullable|date_format:d-M-Y',
            'jenis_bayar'=>'required',
            'total_barang'=>'nullable|numeric',
            'ppn'=>'nullable|numeric',
            'biaya_lain'=>'nullable|numeric',
            'total_bayar'=>'required|numeric',
            'keterangan'=>'nullable|string'
        ]);
    }

    /**
     * Store data
     * if fail, show message
     */
    public function store()
    {
        \DB::beginTransaction();
        try {
            $penjualan = (new PenjualanPureRepo())->store((object) $this->validateData());
            //PenjualanRepository::create((object) $this->validateData(), $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
            session()->flash('message', $e);
        }
        return redirect()->to('penjualan/print/'.$penjualan);
    }

    public function update()
    {
        \DB::beginTransaction();
        try {
            $penjualan = (new PenjualanPureRepo())->update((object) $this->validateData());
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
            session()->flash('message', $e);
        }
        return redirect()->to('penjualan/print/'.$penjualan);
    }
}
