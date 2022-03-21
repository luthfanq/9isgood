<?php

namespace App\Http\Livewire\Stock;

use App\Haramain\Repository\StockAkhirRepository;
use App\Haramain\Traits\LivewireTraits\SetProdukTraits;
use App\Models\Master\Gudang;
use App\Models\Stock\StockAkhir;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class StockAkhirForm extends StockTransaksi
{

    public $jenis;
    public $stock_akhir_id;

    public $pegawai, $pegawai_nama, $tgl_input, $gudang, $keterangan;
    public $gudang_data;

    public $produk_id, $produk_nama, $produk_cover, $produk_kode_lokal, $produk_hal;

    public function render()
    {
        return view('livewire.stock.stock-akhir-form');
    }

    public function mount($id = null)
    {
        $this->gudang_data = Gudang::all();
        if ($id){
            $stock_akhir = StockAkhir::query()->find($id);
            $this->stock_akhir_id = $stock_akhir->id;
            $this->forMount('update', $stock_akhir, $stock_akhir->stock_akhir_detail);
            $this->pegawai_id = $stock_akhir->pegawai_id;
            $this->pegawai_nama = $stock_akhir->pegawai->nama;
        }
    }

    public function store()
    {
        $data_validate = $this->validate([
            'pegawai_id'=>'required',
            'kondisi'=>'required',
            'tgl_input'=>'required',
            'gudang_id'=>'required',
            'keterangan'=>'required',
            'data_detail'=>'required'
        ]);

        \DB::beginTransaction();
        try {
            StockAkhirRepository::create((object)$data_validate, $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
        return redirect()->route('stock.stockakhir');
    }

    public function update()
    {
        $data_validate = $this->validate([
            'stock_akhir_id'=>'required',
            'pegawai_id'=>'required',
            'kondisi'=>'required',
            'tgl_input'=>'required',
            'gudang_id'=>'required',
            'keterangan'=>'required',
            'data_detail'=>'required'
        ]);

        \DB::beginTransaction();
        try {
            StockAkhirRepository::update((object)$data_validate, $this->data_detail);
            \DB::commit();
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
        return redirect()->route('stock.stockakhir');
    }
}
