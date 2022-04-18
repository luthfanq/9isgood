<?php

namespace App\Http\Livewire\Datatables;

use App\Models\Master\Customer;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CustomerSetTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Kode', 'kode')
                ->searchable()
                ->sortable(),
            Column::make('Nama', 'nama')
                ->searchable()
                ->sortable(),
            Column::make('Telepon', 'telepon'),
            Column::make('Diskon', 'diskon'),
            Column::make('Action'),
        ];
    }

    public function query(): Builder
    {
        return Customer::query()
            ->whereNotIn('status_bayar', 'set_piutang');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.customer_set_table';
    }
}
