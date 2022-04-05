<?php

namespace App\Http\Livewire\Stock;

use App\Haramain\Repository\Stock\StockOpnameRepository;
use App\Models\Master\Gudang;
use App\Models\Stock\StockOpname;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StockOpnameForm extends StockTransaksi
{
    public $jenis;

    public function render()
    {
        return view('livewire.stock.stock-opname-form');
    }

    public function mount($jenis, $stockOpname_id = null)
    {
        $this->jenis = $jenis;

        if ($stockOpname_id){
            $stockOpname = StockOpname::query()->find($stockOpname_id);
            $this->stock_id = $stockOpname->id;
            $this->tgl_input = tanggalan_format($stockOpname->tgl_input);
            $this->pegawai_id = $stockOpname->pegawai_id;
            $this->pegawai_nama = $stockOpname->pegawai->nama;
            $this->keterangan = $stockOpname->keterangan;
            $this->forMount('update', $stockOpname, $stockOpname->stockOpnameDetail);
        }
    }

    /**
     * validate data before update or insert
     * @return array
     */
    protected function validateData(): array
    {
        return $this->validate([
            'stock_id'=>'nullable',
            'pegawai_id'=>'required',
            'jenis'=>'required',
            'gudang_id'=>'required',
            'kondisi'=>'required',
            'tgl_input'=>'required|date_format:d-M-Y',
            'keterangan'=>'nullable|string',
            'data_detail'=>'required'
        ]);
    }

    public function store()
    {
        \DB::beginTransaction();
        try {
            StockOpnameRepository::create((object)$this->validateData(), $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
        return redirect()->route('stock.opname');
    }

    public function update()
    {
        \DB::beginTransaction();
        try {
            StockOpnameRepository::update((object)$this->validateData(), $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
        return redirect()->route('stock.opname');
    }
}
