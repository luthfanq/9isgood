<?php

namespace App\Http\Livewire\Datatables\Stock;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Penjualan\Penjualan;
use App\Models\Stock\StockKeluar;
use App\Models\Stock\StockMasuk;
use App\Models\Stock\StockOpname;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockCardIdexTable extends DataTableComponent
{
    use DatatablesTraits;
    public function columns(): array
    {
        return [
            Column::make('Tanggal'),
            Column::make('Kode'),
            Column::make('Produk'),
            Column::make('Masuk'),
            Column::make('Keluar'),
        ];
    }

    public $produk_id;

    public function mount($produk_id)
    {
        $this->produk_id=$produk_id;
    }

    public function query(): Builder
    {
        $stockMasuk = StockMasuk::query()
            ->select('stock_masuk.id as kode', 'produk_id', DB::raw('NULL AS jumlah_keluar'), 'jumlah AS jumlah_masuk', 'tgl_masuk AS tanggal')
            ->rightJoin('stock_masuk_detail as smd', 'smd.stock_masuk_id', '=', 'stock_masuk.id')
            ->where('produk_id', $this->produk_id)
            ->where('active_cash', session('ClosedCash'));
        $stockOpname = StockOpname::query()
            ->select('stock_opname.kode', 'produk_id', DB::raw('NULL AS jumlah_keluar'), 'jumlah AS jumlah_masuk', 'tgl_input AS tanggal')
            ->rightJoin('stock_opname_detail as sod', 'sod.stock_opname_id', '=', 'stock_opname.id')
            ->where('produk_id', $this->produk_id)
            ->where('active_cash', session('ClosedCash'));
        $stockKeluar = StockKeluar::query()
            ->select('stock_keluar.kode', 'produk_id',  DB::raw('NULL AS jumlah_masuk'), 'jumlah as jumlah_keluar', 'tgl_keluar AS tanggal')
            ->rightJoin('stock_keluar_detail', 'stock_keluar_detail.stock_keluar_id', '=', 'stock_keluar.id')
            ->where('produk_id', $this->produk_id)
            ->where('active_cash', session('ClosedCash'))
            ->union($stockOpname)
            ->union($stockMasuk)
            ->latest('tanggal');
        //dd($stockOpname);
        return $stockKeluar;
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_card_idex_table';
    }
}
