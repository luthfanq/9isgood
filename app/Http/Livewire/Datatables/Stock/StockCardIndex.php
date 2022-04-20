<?php

namespace App\Http\Livewire\Datatables\Stock;

use App\Models\Stock\StockKeluar;
use App\Models\Stock\StockMasuk;
use App\Models\Stock\StockOpname;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockCardIndex extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Column Name'),
        ];
    }
    public $produk_id;
    public function mount($produk_id)
    {
        $this->produk_id = $produk_id;
    }

    public function query(): Builder
    {
        $stockMasuk = StockMasuk::query()
            ->selectRaw('kode, produk_id, NULL AS jumlah_keluar, jumlah AS jumlah_masuk, tgl_masuk AS tanggal')
            ->rightJoin('stock_masuk_detail as smd', 'smd.stock_masuk_id', '=', 'stock_masuk.id')
            ->where('produk_id', $this->produk_id);
        $stockKeluar = StockKeluar::query()
            ->selectRaw('kode, produk_id, jumlah AS jumlah_keluar, NULL AS jumlah_masuk,tgl_keluar AS tanggal')
            ->rightJoin('stock_keluar_detail as skd', 'skd.stock_keluar_id', '=', 'stock_keluar.id')
            ->where('produk_id', $this->produk_id);
        return StockOpname::query()
            ->selectRaw('kode, produk_id, NULL AS jumlah_keluar, jumlah AS jumlah_masuk, tgl_input AS tanggal')
            ->rightJoin('stock_opname_detail as sod', 'sod.stock_opname_id', '=', 'stock_opname.id')
            ->where('produk_id', $this->produk_id)
            ->union($stockKeluar)
            ->union($stockMasuk);
    }
}
