<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\NeracaSaldo;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class NeracaSaldoAwalTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('ID'),
            Column::make('Akun ID'),
            Column::make('Debet'),
            Column::make('Kredit'),
            Column::make('Keterangan'),            
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return NeracaSaldo::query()->latest();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.neraca_saldo_awal_table';
    }
}
