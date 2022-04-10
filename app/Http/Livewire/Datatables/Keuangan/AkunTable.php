<?php

namespace App\Http\Livewire\Datatables\Keuangan;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\Akun;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AkunTable extends DataTableComponent
{
    use DatatablesTraits;

    public bool $singleColumnSorting = true;

    public function columns(): array
    {
        return [
            Column::make('Kode', 'kode')
                ->sortable()
                ->searchable(),
            Column::make('Tipe'),
            Column::make('Kategori'),
            Column::make('Akun'),
            Column::make('Keterangan'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return Akun::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.akun_table';
    }
}
