<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Master\Customer;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CustomerTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('ID', 'kode')
                ->searchable(),
            Column::make('Nama')
                ->searchable(),
            Column::make('Diskon')
                ->searchable(),
            Column::make('Telepon'),
            Column::make('Alamat')
                ->searchable(),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return Customer::query()->latest('id');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.customer_table';
    }
}
