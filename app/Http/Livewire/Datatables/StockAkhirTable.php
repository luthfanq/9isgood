<?php

namespace App\Http\Livewire\Datatables;

use App\Models\Stock\StockAkhir;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockAkhirTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('ID', 'kode')
                ->sortable()
                ->searchable()
                ->addClass('hidden md:table-cell')
                ->selected(),
            Column::make('Gudang', 'gudang.nama')
                ->sortable()
                ->searchable(),
            Column::make('Pegawai', 'pegawai.nama')
                ->sortable()
                ->searchable(),
            Column::make('Pembuat', 'users.nama')
                ->sortable()
                ->searchable(),
            Column::make('Tgl Input', 'tgl_input')
                ->sortable()
                ->searchable(),
            Column::make('Action', 'actions')
                ->sortable()
                ->searchable(),
        ];
    }

    public function query(): Builder
    {
        return StockAkhir::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_akhir_table';
    }
}
