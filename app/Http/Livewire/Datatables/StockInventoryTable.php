<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Master\Produk;
use App\Models\Stock\StockInventory;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockInventoryTable extends DataTableComponent
{
    use DatatablesTraits;

    public string $defaultSortColumn = 'produk_id';
    public string $defaultSortDirection = 'asc';

    public function columns(): array
    {
        return [
            Column::make('ID', 'produk.kode_lokal')
                ->searchable(),
            Column::make('Produk', 'produk.nama')
                ->sortable(function(Builder $query, $direction) {
                    return $query->orderBy(Produk::query()->select('nama')->whereColumn('produk.id', 'stock_inventory.produk_id'), $direction);
                })
                ->searchable(),
            Column::make('Kondisi', ''),
            Column::make('Gudang', ''),
            Column::make('Stock Opname', '')
                ->sortable(),
            Column::make('Stock Masuk', '')
                ->sortable(),
            Column::make('Stock Keluar', '')
                ->sortable(),
            Column::make('Stock Sisa', 'stock_saldo')
                ->sortable(),
        ];
    }

    public function query(): Builder
    {
        return StockInventory::query()
            ->where('active_cash', session('ClosedCash'));
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_inventory_table';
    }
}
