<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Master\Gudang;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class GudangTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('ID'),
            Column::make('Nama')
                ->searchable(),
            Column::make('Alamat'),
            Column::make('Keterangan'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return Gudang::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.gudang_table';
    }
}
