<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\NeracaSaldoAwalModel;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class NeracaSaldoAwalTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('Akun ID'),
            Column::make('Pembuat'),
            Column::make('Debet'),
            Column::make('Kredit'),
            Column::make('Keterangan'),            
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return NeracaSaldoAwalModel::query()->latest();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.neraca_saldo_awal_table';
    }
}
