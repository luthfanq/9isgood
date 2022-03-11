<?php

namespace App\Http\Livewire\Stock;

use App\Haramain\Repository\StockKeluarRepository;
use App\Models\Stock\StockKeluar;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class StockKeluarForm extends StockTransaksi
{
    public $kondisi;

    public function mount($kondisi='baik', $stockkeluar = null) : void
    {
        $this->kondisi = $kondisi ? $kondisi :'baik';

        $stockkeluar = StockKeluar::query()->find($kondisi);

        if ($stockkeluar)
        {
            $this->stock_id = $stockkeluar->id;

            $this->forMount('update', $stockkeluar, $stockkeluar->stockKeluarDetail);
        }
    }

    
    public function render()
    {
        return view('livewire.stock.stock-keluar-form');
    }

    
     /**
     * validate data before update or insert
     * @return array
     */
    protected function validateData(): array
    {
        return $this->validate([
            'stock_id'=>'nullable',
            'supplier_id'=>'required',
            'gudang_id'=>'required',
            'kondisi'=>'required',
            'tgl_masuk'=>'nullable|date_format:d-M-Y',
            'tgl_keluar'=>'required|date_format:d-M-Y',
            'keterangan'=>'nullable|string',
        ]);
    }

    /**
     * Store data
     * if fail, show message
     */
    public function store()
    {
        \DB::beginTransaction();
        try{
            StockKeluarRepository::create((object) $this->validateData(), $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollback();
            session()->flash('message', $e);
        }
        return redirect()->route('stock.keluar');
    }

    public function update()
    {
        \DB::beginTransaction();
        try{
            StockKeluarRepository::update((object) $this->validateData(), $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollback();
            session()->flash('message', $e);
        }
        return redirect()->route('stock.keluar');
    }
}
