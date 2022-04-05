<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Stock\StockInventory;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockInventoryByKondisiTable extends DataTableComponent
{
    use DatatablesTraits;
    public $jenis, $gudang;

    public function mount($jenis, $gudang)
    {
        $this->jenis = $jenis;
        $this->gudang = $gudang;
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'produk_id'),
            Column::make('Produk', ''),
            Column::make('Kondisi', ''),
            Column::make('Gudang', ''),
            Column::make('Stock Opname', ''),
            Column::make('Stock Masuk', ''),
            Column::make('Stock Keluar', ''),
            Column::make('Stock Sisa', ''),
        ];
    }

    public function query(): Builder
    {
        return StockInventory::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $this->jenis)
            ->whereRelation('gudang', 'id', $this->gudang);
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_inventory_by_kondisi_table';
    }
}
